import { mkdir, writeFile } from "node:fs/promises";
import { fileURLToPath } from "node:url";
import { dirname, join } from "node:path";

const ROOT = dirname(dirname(fileURLToPath(import.meta.url)));
const OUTPUT_DIR = join(ROOT, "assets", "conversational-framework", "schema");
const SOURCE_DIR = join(OUTPUT_DIR, "excalidraw");

const WIDTH = 1600;
const HEIGHT = 900;
const BG = "#ffffff";
const INK = "#1f2937";
const MUTED = "#94a3b8";
const LEARNER = "#dbeafe";
const TEACHER = "#fef3c7";
const PEER = "#ede9fe";
const ENVIRONMENT = "#dcfce7";

const TYPE_COLORS = {
  acquisition: "#0284c7",
  enquete: "#ea580c",
  pratique: "#7c3aed",
  discussion: "#2563eb",
  collaboration: "#ca8a04",
  production: "#16a34a",
};

const xmlEscape = (value) =>
  String(value)
    .replaceAll("&", "&amp;")
    .replaceAll("<", "&lt;")
    .replaceAll(">", "&gt;")
    .replaceAll('"', "&quot;");

const hash = (value) => {
  let result = 2166136261;
  for (const char of value) {
    result ^= char.charCodeAt(0);
    result = Math.imul(result, 16777619);
  }
  return result >>> 0;
};

const scene = (name) => ({ name, elements: [], svg: [] });

function baseElement(id, type, x, y, width, height, options = {}) {
  return {
    id,
    type,
    x,
    y,
    width,
    height,
    angle: 0,
    strokeColor: options.stroke ?? INK,
    backgroundColor: options.fill ?? "transparent",
    fillStyle: "solid",
    strokeWidth: options.strokeWidth ?? 2,
    strokeStyle: options.strokeStyle ?? "solid",
    roughness: options.roughness ?? 1,
    opacity: options.opacity ?? 100,
    groupIds: options.groupIds ?? [],
    frameId: null,
    index: options.index ?? `a${hash(id).toString(36)}`,
    roundness: options.roundness ?? null,
    seed: hash(id),
    version: 1,
    versionNonce: hash(`${id}-nonce`),
    isDeleted: false,
    boundElements: [],
    updated: 1,
    link: null,
    locked: false,
  };
}

function addRect(s, id, x, y, width, height, options = {}) {
  const radius = options.radius ?? 24;
  const element = {
    ...baseElement(id, "rectangle", x, y, width, height, {
      ...options,
      roundness: { type: 3 },
    }),
  };
  s.elements.push(element);

  const opacity = (options.opacity ?? 100) / 100;
  const stroke = options.stroke ?? INK;
  const fill = options.fill ?? "transparent";
  const strokeWidth = options.strokeWidth ?? 2.4;
  const dash = options.strokeStyle === "dashed" ? ' stroke-dasharray="10 8"' : "";
  s.svg.push(
    `<g opacity="${opacity}">`,
    `<rect x="${x}" y="${y}" width="${width}" height="${height}" rx="${radius}" fill="${fill}" stroke="${stroke}" stroke-width="${strokeWidth}"${dash}/>`,
    `<rect x="${x + 1.2}" y="${y - 0.7}" width="${width - 1}" height="${height + 0.4}" rx="${radius}" fill="none" stroke="${stroke}" stroke-width="1.05" opacity=".48"${dash}/>`,
    `</g>`,
  );
}

function addText(s, id, text, x, y, width, options = {}) {
  const lines = text.split("\n");
  const fontSize = options.fontSize ?? 30;
  const lineHeight = options.lineHeight ?? 1.2;
  const height = lines.length * fontSize * lineHeight;
  const color = options.color ?? INK;
  const align = options.align ?? "center";
  const anchor = align === "left" ? "start" : align === "right" ? "end" : "middle";
  const textX = align === "left" ? x : align === "right" ? x + width : x + width / 2;
  const weight = options.weight ?? 500;
  const italic = options.italic ? "italic" : "normal";
  const opacity = (options.opacity ?? 100) / 100;

  s.elements.push({
    ...baseElement(id, "text", x, y, width, height, {
      stroke: color,
      fill: "transparent",
      roughness: 0,
      opacity: options.opacity,
    }),
    fontSize,
    fontFamily: 2,
    text,
    textAlign: align,
    verticalAlign: "middle",
    containerId: null,
    originalText: text,
    autoResize: true,
    lineHeight,
  });

  const firstY = y + fontSize;
  s.svg.push(
    `<text x="${textX}" y="${firstY}" text-anchor="${anchor}" fill="${color}" opacity="${opacity}" font-family="Arial, Helvetica, sans-serif" font-size="${fontSize}" font-weight="${weight}" font-style="${italic}">`,
    ...lines.map(
      (line, index) =>
        `<tspan x="${textX}" y="${firstY + index * fontSize * lineHeight}">${xmlEscape(line)}</tspan>`,
    ),
    `</text>`,
  );
}

function pathFromPoints(points, curve = 0) {
  if (points.length === 2 && curve !== 0) {
    const [start, end] = points;
    const mx = (start[0] + end[0]) / 2;
    const my = (start[1] + end[1]) / 2 + curve;
    return `M ${start[0]} ${start[1]} Q ${mx} ${my} ${end[0]} ${end[1]}`;
  }
  if (points.length === 3) {
    return `M ${points[0][0]} ${points[0][1]} Q ${points[1][0]} ${points[1][1]} ${points[2][0]} ${points[2][1]}`;
  }
  return points.map((point, index) => `${index === 0 ? "M" : "L"} ${point[0]} ${point[1]}`).join(" ");
}

function addArrow(s, id, points, options = {}) {
  const color = options.color ?? INK;
  const curve = options.curve ?? 0;
  const both = options.both ?? false;
  const hasEndArrow = options.endArrowhead !== false;
  const hasStartArrow = both || options.startArrowhead === true;
  const width = options.strokeWidth ?? 3;
  const opacity = options.opacity ?? 100;
  const xs = points.map(([x]) => x);
  const ys = points.map(([, y]) => y);
  const minX = Math.min(...xs);
  const minY = Math.min(...ys);
  const maxX = Math.max(...xs);
  const maxY = Math.max(...ys);
  const relativePoints = points.map(([x, y]) => [x - minX, y - minY]);

  s.elements.push({
    ...baseElement(id, "arrow", minX, minY, maxX - minX, maxY - minY, {
      stroke: color,
      fill: "transparent",
      strokeWidth: width,
      opacity,
      roundness: { type: 2 },
    }),
    points: relativePoints,
    lastCommittedPoint: null,
    startBinding: null,
    endBinding: null,
    startArrowhead: hasStartArrow ? "arrow" : null,
    endArrowhead: hasEndArrow ? "arrow" : null,
    elbowed: false,
  });

  const d = pathFromPoints(points, curve);
  const arrowhead = (tip, from) => {
    const dx = tip[0] - from[0];
    const dy = tip[1] - from[1];
    const length = Math.hypot(dx, dy) || 1;
    const ux = dx / length;
    const uy = dy / length;
    const size = Math.max(16, width * 5.5);
    const half = size * 0.55;
    const baseX = tip[0] - ux * size;
    const baseY = tip[1] - uy * size;
    const leftX = baseX - uy * half;
    const leftY = baseY + ux * half;
    const rightX = baseX + uy * half;
    const rightY = baseY - ux * half;
    return `<path d="M ${tip[0]} ${tip[1]} L ${leftX} ${leftY} L ${rightX} ${rightY} Z" fill="${color}" stroke="${color}" stroke-width="1"/>`;
  };
  const startHead = hasStartArrow ? arrowhead(points[0], points[1]) : "";
  const endHead = hasEndArrow
    ? arrowhead(points.at(-1), points.length > 2 ? points.at(-2) : points[0])
    : "";
  s.svg.push(
    `<g opacity="${opacity / 100}">`,
    `<path d="${d}" fill="none" stroke="${color}" stroke-width="${width}" stroke-linecap="round" stroke-linejoin="round"/>`,
    `<path d="${d}" transform="translate(.9,-.7)" fill="none" stroke="${color}" stroke-width="1.15" stroke-linecap="round" opacity=".52"/>`,
    startHead,
    endHead,
    `</g>`,
  );
}

function addPill(s, id, label, x, y, width, color) {
  addRect(s, `${id}-box`, x, y, width, 62, {
    fill: "#ffffff",
    stroke: color,
    strokeWidth: 2.2,
    radius: 18,
  });
  addText(s, `${id}-text`, label, x, y + 11, width, {
    fontSize: 28,
    color,
    weight: 650,
  });
}

function addNode(s, id, label, x, y, width, height, options = {}) {
  const fontSize = options.fontSize ?? 27;
  const lineCount = label.split("\n").length;
  const lineSpacing = fontSize * 1.2;
  const textY =
    y + height / 2 - ((lineCount - 1) * lineSpacing) / 2 - fontSize * 0.65;

  addRect(s, `${id}-box`, x, y, width, height, {
    fill: options.fill ?? "#ffffff",
    stroke: options.stroke ?? "#5f5f5f",
    strokeWidth: 2,
    radius: 20,
  });
  addText(s, `${id}-text`, label, x + 8, textY, width - 16, {
    fontSize,
    color: options.color ?? "#111111",
    weight: options.weight ?? 500,
  });
}

const P = {
  field: [680, 210, 255, 545],
  teacherConcept: [260, 258, 165, 105],
  learnerConcept: [690, 258, 225, 105],
  peerConcept: [1190, 258, 180, 105],
  environment: [220, 612, 230, 105],
  learnerPractice: [690, 612, 225, 105],
  peerPractice: [1195, 612, 175, 105],
};

function addLearner(s, cycleMode = "full") {
  addRect(s, "learner-field", ...P.field, {
    fill: "#dedede",
    stroke: "#888888",
    strokeWidth: 1.8,
    radius: 42,
  });
  addNode(s, "learner-concept", "Learner\nconcepts", ...P.learnerConcept, {
    color: "#7d7d7d",
    weight: 700,
    fontSize: 31,
  });
  addNode(s, "learner-practice", "Learner\npractice", ...P.learnerPractice, {
    color: "#7d7d7d",
    weight: 700,
    fontSize: 31,
  });

  const red = "#ff1f1f";
  addArrow(s, "concept-loop-top", [[750, 258], [802, 220], [855, 258]], { color: red });
  if (cycleMode !== "concept-top") {
    addArrow(s, "concept-loop-bottom", [[855, 363], [802, 397], [750, 363]], {
      color: red,
    });
  }
  if (cycleMode === "full") {
    addArrow(s, "practice-loop-top", [[750, 612], [802, 575], [855, 612]], {
      color: red,
    });
    addArrow(s, "practice-loop-bottom", [[855, 717], [802, 755], [750, 717]], {
      color: red,
    });
    addArrow(s, "concept-to-practice", [[705, 363], [665, 488], [705, 612]], {
      color: red,
    });
    addArrow(s, "practice-to-concept", [[900, 612], [940, 488], [900, 363]], {
      color: red,
    });
  }
}

function addOuterNodes(s, environmentLabel = "Learning\nenvironment") {
  addNode(s, "teacher-concept", "Teacher\nconcepts", ...P.teacherConcept);
  addNode(s, "peer-concept", "Peer\nconcepts", ...P.peerConcept);
  addNode(s, "environment", environmentLabel, ...P.environment, {
    color: environmentLabel === "Mock election" ? "#c40000" : "#111111",
  });
  addNode(s, "peer-practice", "Peer\npractice", ...P.peerPractice);

  addArrow(s, "teacher-model-left", [[285, 363], [270, 488], [300, 612]], {
    color: "#8a8a8a",
    strokeWidth: 2,
    endArrowhead: false,
  });
  addArrow(s, "teacher-model-right", [[400, 363], [420, 488], [390, 612]], {
    color: "#8a8a8a",
    strokeWidth: 2,
    endArrowhead: false,
  });
}

function addPeerVerticals(s) {
  addArrow(s, "peer-model-left", [[1225, 363], [1210, 488], [1230, 612]], {
    color: "#8a8a8a",
    strokeWidth: 2,
    endArrowhead: false,
  });
  addArrow(s, "peer-model-right", [[1330, 363], [1345, 488], [1325, 612]], {
    color: "#8a8a8a",
    strokeWidth: 2,
    endArrowhead: false,
  });
}

function addBaseFramework(
  s,
  environmentLabel = "Learning\nenvironment",
  cycleMode = "full",
) {
  addLearner(s, cycleMode);
  addOuterNodes(s, environmentLabel);
}

function addActivity(s, id, label, x, y, width, fill, stroke) {
  addRect(s, `${id}-box`, x, y, width, 78, {
    fill,
    stroke,
    strokeWidth: 1.8,
    radius: 18,
  });
  addText(s, `${id}-text`, label, x + 8, y + 21, width - 16, {
    fontSize: 30,
    color: "#111111",
    weight: 500,
  });
}

function addLearningTypeTitle(s) {
  addText(s, "mapping-title", "Types of learning mapped to the framework", 335, 45, 930, {
    fontSize: 46,
    color: "#082d6d",
    weight: 500,
  });
}

function addQuestionTitle(s) {
  addText(
    s,
    "question-title",
    "What does it take to learn in formal education?",
    250,
    55,
    1100,
    {
      fontSize: 46,
      color: "#082d6d",
      weight: 500,
    },
  );
}

function addBottomTitle(s, label) {
  addText(s, "bottom-title", `Learning through ‘${label}’`, 420, 825, 760, {
    fontSize: 34,
    color: "#111111",
    weight: 500,
  });
}

function addTeacherConceptExchange(s, options = {}) {
  addArrow(s, "teacher-to-learner", [[425, 258], [555, 220], [690, 258]], {
    color: options.forwardColor ?? "#111111",
  });
  if (options.reverse !== false) {
    addArrow(s, "learner-to-teacher", [[690, 345], [555, 390], [425, 345]], {
      color: options.reverseColor ?? "#111111",
    });
  }
}

function addPeerConceptExchange(s, options = {}) {
  addArrow(s, "learner-to-peer", [[915, 258], [1055, 220], [1190, 258]], {
    color: options.forwardColor ?? "#111111",
  });
  if (options.reverse !== false) {
    addArrow(s, "peer-to-learner", [[1190, 345], [1055, 390], [915, 345]], {
      color: options.reverseColor ?? "#111111",
    });
  }
}

function addEnvironmentExchange(s, options = {}) {
  addArrow(s, "environment-to-learner", [[450, 630], [570, 575], [690, 630]], {
    color: options.forwardColor ?? "#111111",
  });
  addArrow(s, "learner-to-environment", [[690, 700], [570, 760], [450, 700]], {
    color: options.reverseColor ?? "#ff1f1f",
  });
}

function addPeerPracticeExchange(s, options = {}) {
  addArrow(s, "learner-to-peer-practice", [[915, 630], [1055, 575], [1195, 630]], {
    color: options.forwardColor ?? "#ff1f1f",
  });
  addArrow(s, "peer-to-learner-practice", [[1195, 700], [1055, 760], [915, 700]], {
    color: options.reverseColor ?? "#111111",
  });
}

function buildCore() {
  const s = scene("cadre-03");
  addQuestionTitle(s);
  addLearner(s);
  return s;
}

function buildFramework() {
  const s = scene("cadre-04");
  addQuestionTitle(s);
  addBaseFramework(s, "Mock election");
  addPeerVerticals(s);
  addTeacherConceptExchange(s);
  addPeerConceptExchange(s);
  addEnvironmentExchange(s, { forwardColor: "#111111", reverseColor: "#111111" });
  addPeerPracticeExchange(s, { forwardColor: "#111111", reverseColor: "#111111" });

  addText(s, "teacher-communication", "Teacher\ncommunication\ncycle", 435, 240, 220, {
    fontSize: 30,
    color: "#174b8b",
    italic: true,
  });
  addText(s, "peer-communication", "Peer\ncommunication\ncycle", 960, 240, 190, {
    fontSize: 30,
    color: "#174b8b",
    italic: true,
  });
  addText(s, "teacher-modelling", "Teacher\nmodelling\ncycle", 455, 612, 190, {
    fontSize: 29,
    color: "#174b8b",
    italic: true,
  });
  addText(s, "peer-modelling", "Peer\nmodelling\ncycle", 960, 612, 180, {
    fontSize: 29,
    color: "#174b8b",
    italic: true,
  });
  return s;
}

function buildAcquisition() {
  const s = scene("cadre-05");
  addLearningTypeTitle(s);
  addBaseFramework(s, "Learning\nenvironment", "concept-top");
  addTeacherConceptExchange(s, { reverse: false });
  addActivity(s, "activity", "Acquiring", 435, 130, 230, "#9ddcf5", "#0ea5e9");
  addText(s, "concepts-ideas", "Concepts\nIdeas", 480, 210, 140, {
    fontSize: 28,
    color: "#111111",
  });
  addBottomTitle(s, "acquisition");
  return s;
}

function buildInquiry() {
  const s = scene("cadre-06");
  addLearningTypeTitle(s);
  addBaseFramework(s, "Learning\nenvironment", "concept");
  addTeacherConceptExchange(s, { reverseColor: "#ff1f1f" });
  addActivity(s, "activity", "Inquiring", 440, 258, 230, "#f6a36d", "#c2410c");
  addText(s, "ideas", "Ideas", 505, 205, 100, { fontSize: 27 });
  addText(s, "questions", "Questions", 485, 365, 145, { fontSize: 27 });
  addBottomTitle(s, "inquiry");
  return s;
}

function buildPractice() {
  const s = scene("cadre-07");
  addLearningTypeTitle(s);
  addBaseFramework(s);
  addEnvironmentExchange(s);
  addActivity(s, "activity", "Practising", 482, 628, 165, "#d8c5ed", "#7c3aed");
  addText(s, "feedback", "Feedback", 490, 560, 155, { fontSize: 27 });
  addText(s, "action", "Action", 505, 735, 130, { fontSize: 27 });
  addBottomTitle(s, "practice");
  return s;
}

function buildDiscussion() {
  const s = scene("cadre-08");
  addLearningTypeTitle(s);
  addBaseFramework(s, "Learning\nenvironment", "concept");
  addPeerConceptExchange(s, { forwardColor: "#ff1f1f", reverseColor: "#111111" });
  addActivity(s, "activity", "Discussing", 960, 258, 220, "#8db4e8", "#2563eb");
  addText(s, "ideas", "Ideas", 1015, 205, 115, { fontSize: 27 });
  addText(s, "questions", "Questions", 1000, 365, 150, { fontSize: 27 });
  addBottomTitle(s, "discussion");
  return s;
}

function buildCollaboration() {
  const s = scene("cadre-09");
  addLearningTypeTitle(s);
  addBaseFramework(s);
  addPeerConceptExchange(s, { forwardColor: "#ff1f1f", reverseColor: "#111111" });
  addEnvironmentExchange(s);
  addPeerPracticeExchange(s);
  addActivity(s, "activity", "Collaborating", 945, 628, 220, "#ffe39a", "#ca8a04");
  addText(s, "questions", "Questions", 995, 205, 160, { fontSize: 27 });
  addText(s, "ideas", "Ideas", 1020, 365, 110, { fontSize: 27 });
  addText(s, "feedback", "Feedback", 490, 560, 155, { fontSize: 27 });
  addText(s, "action", "Action", 505, 735, 130, { fontSize: 27 });
  addText(s, "outputs-top", "Outputs", 1010, 560, 130, { fontSize: 27 });
  addText(s, "outputs-bottom", "Outputs", 1010, 735, 130, { fontSize: 27 });
  addBottomTitle(s, "collaboration");
  return s;
}

function buildProduction() {
  const s = scene("cadre-10");
  addLearningTypeTitle(s);
  addBaseFramework(s);
  addTeacherConceptExchange(s, { forwardColor: "#111111", reverseColor: "#ff1f1f" });
  addActivity(s, "activity", "Producing", 435, 258, 230, "#b9e887", "#16a34a");
  addText(s, "feedback", "Feedback", 485, 205, 150, { fontSize: 27 });
  addText(s, "outputs", "Outputs", 490, 365, 140, { fontSize: 27 });
  addBottomTitle(s, "production");
  return s;
}

function buildComplete() {
  const s = scene("cadre-11");
  addBaseFramework(s);
  addTeacherConceptExchange(s, { reverseColor: "#ff1f1f" });
  addPeerConceptExchange(s, { forwardColor: "#ff1f1f", reverseColor: "#111111" });
  addEnvironmentExchange(s);
  addPeerPracticeExchange(s);

  addActivity(s, "acquiring", "Acquiring", 440, 172, 230, "#9ddcf5", "#0ea5e9");
  addActivity(s, "inquiring", "Inquiring", 440, 262, 230, "#f6a36d", "#c2410c");
  addActivity(s, "producing", "Producing", 440, 360, 230, "#b9e887", "#16a34a");
  addActivity(s, "discussion", "Discussion", 960, 260, 220, "#8db4e8", "#2563eb");
  addActivity(s, "practising", "Practising", 480, 628, 165, "#d8c5ed", "#7c3aed");
  addActivity(s, "collaborating", "Collaborating", 945, 628, 220, "#ffe39a", "#ca8a04");

  addText(
    s,
    "closing-note",
    "All these learning types are encouraged through a variety of\nconventional and online methods",
    330,
    800,
    940,
    {
      fontSize: 31,
      color: "#8b0000",
      italic: true,
      weight: 500,
    },
  );
  return s;
}

function svgDocument(s) {
  const markers = [...new Set([INK, MUTED, "#2563eb", "#e11d48", ...Object.values(TYPE_COLORS)])]
    .map((color) => {
      const id = color.replace("#", "");
      return `<marker id="arrow-${id}" markerWidth="12" markerHeight="12" refX="10" refY="6" orient="auto-start-reverse" markerUnits="strokeWidth"><path d="M 1 1 L 11 6 L 1 11 z" fill="${color}"/></marker>`;
    })
    .join("");

  return [
    `<svg xmlns="http://www.w3.org/2000/svg" width="${WIDTH}" height="${HEIGHT}" viewBox="0 0 ${WIDTH} ${HEIGHT}" role="img" aria-labelledby="title desc">`,
    `<title id="title">${xmlEscape(s.name)}</title>`,
    `<desc id="desc">Illustration du Cadre conversationnel recréée dans un style Excalidraw.</desc>`,
    `<defs>${markers}</defs>`,
    `<rect width="${WIDTH}" height="${HEIGHT}" fill="${BG}"/>`,
    ...s.svg,
    `</svg>`,
    "",
  ].join("\n");
}

function excalidrawDocument(s) {
  return JSON.stringify(
    {
      type: "excalidraw",
      version: 2,
      source: "https://excalidraw.com",
      elements: s.elements,
      appState: {
        gridSize: null,
        viewBackgroundColor: BG,
      },
      files: {},
    },
    null,
    2,
  );
}

const scenes = [
  buildCore(),
  buildFramework(),
  buildAcquisition(),
  buildInquiry(),
  buildPractice(),
  buildDiscussion(),
  buildCollaboration(),
  buildProduction(),
  buildComplete(),
];

await mkdir(SOURCE_DIR, { recursive: true });

for (const current of scenes) {
  await writeFile(join(OUTPUT_DIR, `${current.name}.svg`), svgDocument(current), "utf8");
  await writeFile(
    join(SOURCE_DIR, `${current.name}.excalidraw`),
    excalidrawDocument(current),
    "utf8",
  );
}

console.log(`Generated ${scenes.length} SVG exports and Excalidraw source files.`);
