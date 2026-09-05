const { test } = require('node:test');
const assert = require('node:assert/strict');
const fs = require('node:fs');
const path = require('node:path');
const vm = require('node:vm');

function loadModules() {
  const context = vm.createContext({ window: {}, TextEncoder });
  // Use the order shipped to the browser, including the real competency sources.
  const designer = fs.readFileSync(path.join(__dirname, '../designer.php'), 'utf8');
  const scripts = [...designer.matchAll(/<script src="(js\/(?:competency-[^"?]+|editor\/[^"?]+)\.js)\?/g)];
  for (const [, filename] of scripts) {
    vm.runInContext(fs.readFileSync(path.join(__dirname, '..', filename), 'utf8'), context, { filename });
  }
  return context;
}

test('the deployed modules load without DOM access or editor initialization', () => {
  const context = loadModules();
  const modules = context.window.LearningDesignerModules;
  for (const factory of ['createCompetencies', 'createExports', 'createImports', 'createAnalysis', 'createFields']) {
    assert.equal(typeof modules[factory], 'function', factory);
  }
  assert.equal(modules.config.I18N.fr.save, 'Enregistrer');
  assert.equal(modules.config.I18N.en.save, 'Save');
});

test('competency labels follow language changes without rebuilding the catalogs', () => {
  const context = loadModules();
  vm.runInContext(`
    let language = 'fr';
    globalThis.competencies = window.LearningDesignerModules.createCompetencies({
      COMPETENCY_CATALOG_SOURCE, COMPETENCY_CATALOG_EN_SOURCE,
      COMPETENCY_FRAMEWORK_CATALOG_SOURCE, COMPETENCY_GREENCOMP_DETAIL_SOURCE,
      COMPETENCY_DIGCOMP_DETAIL_SOURCE,
      normalizeToken: window.LearningDesignerModules.config.normalizeToken,
      currentLang: () => language
    });
  `, context);
  const catalog = context.competencies;
  const entry = catalog.SELECTABLE_TOOLS_DATA.find(tool => tool.labelFr !== tool.labelEn);
  assert.ok(entry);
  const french = catalog.formatCompetencyLabel(entry);
  vm.runInContext("language = 'en'", context);
  assert.notEqual(catalog.formatCompetencyLabel(entry), french);
  assert.ok(catalog.COMPETENCY_REFERENCE_MAP[context.window.LearningDesignerModules.config.normalizeToken(entry.id)]);
});

function documentWith(name, id, instructions) {
  return { meta: { name }, sessions: [{ id, title: name, activities: [{ instructions }] }] };
}

for (const format of ['Markdown', 'Html', 'Word', 'Excel']) {
  test(`${format} student export reads the replacement document and applies session selection`, () => {
    const modules = loadModules().window.LearningDesignerModules;
    let current = documentWith('Original title', 'old', 'Original instructions');
    const exporter = modules.createExports({ getState: () => current, escapeHtml: text => String(text) });
    const build = exporter[`build${format}Export${format === 'Markdown' ? '' : 'Document'}`];
    const decode = content => typeof content === 'string' ? content : new TextDecoder().decode(content);
    assert.match(decode(build('students')), /Original instructions/);
    current = documentWith('Replacement title', 'new', 'Replacement instructions');
    current.sessions.push({ id: 'excluded', title: 'Excluded title', activities: [{ instructions: 'Private instructions' }] });
    const selected = decode(build('students', ['new']));
    assert.match(selected, /Replacement instructions/);
    assert.doesNotMatch(selected, /Original instructions|Private instructions/);
    assert.doesNotMatch(decode(build('students', [])), /Replacement instructions|Private instructions/);
  });
}
