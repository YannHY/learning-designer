<?php
declare(strict_types=1);

/**
 * English content for the built-in scenario templates.
 *
 * Kept separate from models.php so the compact French source remains readable.
 * The array mirrors model content by id and positional moment/activity indexes.
 */
return json_decode(
    <<<'JSON'
{
  "introduire-chapitre": {
    "description": "Opening session of [CHAPITRE] in [MATIÈRE], [NIVEAU]. The students start from their representations, formulate the guiding question, receive an initial structured input and leave with the chapter plan.",
    "command": "Program of [MATIÈRE], [NIVEAU]: entry in [CHAPITRE].",
    "personas": "1) Make the initial representations visible on [NOTION 1]. 2) Set up the guiding question that will guide the entire chapter.",
    "outcomes": [
      {
        "verb": "Name",
        "text": "Name the key concepts of [CHAPITRE] and their minimum definition."
      },
      {
        "verb": "Rephrase",
        "text": "Restate the leading question of [CHAPITRE] in your own words."
      },
      {
        "verb": "Explain",
        "text": "Explain [NOTION 1] based on the example studied in class."
      },
      {
        "verb": "Distinguish",
        "text": "Distinguish what falls under [NOTION 1] from what falls under [NOTION VOISINE]."
      }
    ],
    "moments": [
      {
        "objectives": "Spark interest and create a need to know from a triggering document.",
        "intentions": "Brief and concrete hook: it serves to open a gap between what the students believe and what they observe, not to expose the content.",
        "notes": "Project [DOCUMENT DÉCLENCHEUR] before entering class. Don't explain anything at this point.",
        "activities": [
          {
            "description": "Projection of [DOCUMENT DÉCLENCHEUR] (image, video extract, figure, press title) without comment. Students write down what they observe and what surprises them.",
            "instructions": "Look at [DOCUMENT DÉCLENCHEUR] in silence. Note two things: what you observe, and what surprises you."
          }
        ]
      },
      {
        "objectives": "Bring out initial representations and identify misconceptions.",
        "intentions": "Diagnosis with socio-cognitive conflict value: nothing is corrected here. Student formulations are kept to be used at the end of the chapter.",
        "notes": "Write down three student formulations on the board, without correcting them, and photograph them.",
        "activities": [
          {
            "description": "Three assertions on [NOTION 1] submitted to a vote by show of hands, then justification by two students from opposing camps. No validation at this stage.",
            "instructions": "For each projected statement: agree / disagree / I don’t know. If I ask you, say what makes you think that, without looking for the right answer."
          }
        ]
      },
      {
        "objectives": "Transform initial astonishment into the guiding question of the chapter.",
        "intentions": "The question is first formulated by the students, then reformulated by the teacher. It remains displayed throughout the chapter.",
        "activities": [
          {
            "description": "In pairs, students write the question that the chapter should answer. Two or three proposals are retained and then merged.",
            "instructions": "With your neighbor, write in one sentence the question that this chapter should answer. It begins with “How”, “Why” or “To what extent”."
          }
        ]
      },
      {
        "objectives": "Give the minimum notions and vocabulary to enter the chapter.",
        "intentions": "Short, cut-up contribution, followed by a written reformulation: the attention in the presentation drops after around fifteen minutes.",
        "activities": [
          {
            "description": "Teacher's presentation on [NOTION 1] and [NOTION 2], based on the example of the trigger document.",
            "instructions": "Listen and note only new words and their definitions. The written record will come next."
          },
          {
            "description": "Written reformulation of the central concept, recorded orally from three students chosen at random.",
            "instructions": "In two lines, explain [NOTION 1] in your words, without looking at your notes."
          }
        ]
      },
      {
        "objectives": "Set the vocabulary, the leading question and the route of the chapter.",
        "intentions": "Written trace co-constructed rather than dictated: the student must be able to find the logic of the chapter alone.",
        "activities": [
          {
            "description": "Completion of a chapter sheet: guiding question, definitions, three-part plan, deadlines.",
            "instructions": "Complete the chapter sheet: the guiding question, definitions, plan and date of the evaluation."
          }
        ]
      }
    ]
  },
  "reactiver-prerequis": {
    "description": "Half session of 30 min before starting [CHAPITRE] in [MATIÈRE]. Objective: to know precisely what is acquired from [PRÉREQUIS 1] and [PRÉREQUIS 2] before moving forward.",
    "command": "Program of [MATIÈRE], [NIVEAU]: the acquired skills of [PRÉREQUIS 1] and [PRÉREQUIS 2] condition entry into [CHAPITRE].",
    "personas": "1) Measure the actual state of the prerequisites. 2) Address the two most common errors immediately.",
    "outcomes": [
      {
        "verb": "Recall",
        "text": "Recall the definition and main property of [PRÉREQUIS 1]."
      },
      {
        "verb": "Apply",
        "text": "Apply [PRÉREQUIS 2] to a short unassisted exercise."
      },
      {
        "verb": "Examine",
        "text": "Examine your own copy to precisely locate the origin of your error."
      }
    ],
    "moments": [
      {
        "objectives": "Measure what is actually available in memory before the new chapter.",
        "intentions": "Test without grade and without document: its function is to make deficiencies visible to the student himself, not to punish.",
        "notes": "Provide [NOMBRE] short questions, at least two of which relate to the classic error of [PRÉREQUIS 2].",
        "activities": [
          {
            "description": "Short quiz on [PRÉREQUIS 1] and [PRÉREQUIS 2], without notes and without documents.",
            "instructions": "Answer alone, without your notes. This test is not graded: what matters is to identify what you have not yet mastered."
          }
        ]
      },
      {
        "objectives": "Have the procedures explained and compare the approaches.",
        "intentions": "Correction by a peer requires the procedure to be verbalized; the teacher circulates and notes recurring errors for the next moment.",
        "activities": [
          {
            "description": "Exchange copies in pairs: each student explains to the other how they did it, without giving the ready answer.",
            "instructions": "Exchange your copy with your neighbor. For each discrepancy, explain to him how you reasoned. Circle together the questions where you disagree."
          }
        ]
      },
      {
        "objectives": "Correct the two most fragile points before entering the new chapter.",
        "intentions": "Resumption deliberately limited to two points: it is better to solidly reinstall the essentials than to skim over the entire previous program.",
        "activities": [
          {
            "description": "List of the two most frequent errors noted, with an explicit counter-example.",
            "instructions": "Write down the corrected procedure in your notebook, where you made a mistake, and indicate in a color what remains to be reviewed at home."
          }
        ]
      }
    ]
  },
  "classe-inversee": {
    "description": "Hybrid lesson on [NOTION 1]: 20 minutes of asynchronous work at home using [CAPSULE / DOCUMENT], followed by 55 minutes in class devoted to application and resolving difficulties.",
    "command": "[MATIÈRE] curriculum, [NIVEAU]: [NOTION 1]. Class time is reserved for work that students cannot complete effectively on their own.",
    "personas": "1) Move initial exposure to the content outside the classroom. 2) Devote class time to application and resolving difficulties.",
    "outcomes": [
      {
        "verb": "Explain",
        "text": "Explain [NOTION 1] using the learning resource studied at home."
      },
      {
        "verb": "Apply",
        "text": "Apply [NOTION 1] to a new situation in a group."
      },
      {
        "verb": "Question",
        "text": "Formulate a precise question about a point that remains unclear."
      }
    ],
    "moments": [
      {
        "objectives": "Engage with the content and identify any points that remain unclear.",
        "intentions": "Students must produce notes and a question: without an active response, viewing remains passive and the follow-up lesson loses its foundation.",
        "notes": "Share [CAPSULE / DOCUMENT] at least 48 hours beforehand. Provide an alternative for students without internet access.",
        "activities": [
          {
            "description": "Students watch or read [CAPSULE / DOCUMENT], take guided notes and formulate one question.",
            "instructions": "Watch or read [CAPSULE / DOCUMENT] before class. Complete the notes sheet, then write one question about something you did not understand. Bring it to class."
          }
        ]
      },
      {
        "objectives": "Check that students have studied the resource and identify difficulties.",
        "intentions": "This is a quick, ungraded check: it helps students start the task and avoids repeating content they already understand.",
        "activities": [
          {
            "description": "A three-question quiz on the learning resource, followed by collecting students’ questions on the board.",
            "instructions": "Answer the three questions, then write your question on the board or on the collaborative wall."
          }
        ]
      },
      {
        "objectives": "Apply [NOTION 1] collaboratively to a new situation.",
        "intentions": "This is the core of the class session: the teacher circulates, intervenes when asked and notes approaches to discuss afterwards.",
        "activities": [
          {
            "description": "Groups complete [TÂCHE D’APPLICATION] and produce a shared, reasoned response.",
            "instructions": "In a group of three, complete [TÂCHE D’APPLICATION]. Submit one shared response and be ready to justify each step."
          }
        ]
      },
      {
        "objectives": "Compare approaches and establish the reference method.",
        "intentions": "Only two groups present, selected for their contrasting approaches: comparison is more useful than repetition.",
        "activities": [
          {
            "description": "Two groups present contrasting approaches, then the teacher formalises the reference method.",
            "instructions": "Listen to both approaches, identify the one closest to yours, then record the reference method."
          }
        ]
      }
    ]
  },
  "cours-dialogue": {
    "description": "Transmission session on [NOTION 1] in [MATIÈRE], [NIVEAU]. The presentation is divided into two blocks between which the students reformulate in writing; the final synthesis is completed in class.",
    "command": "Program for [MATIÈRE], [NIVEAU]: [NOTION 1] and [NOTION 2].",
    "personas": "1) Transmit demanding content while maintaining attention. 2) Have a written record produced that can be used for review.",
    "outcomes": [
      {
        "verb": "Define",
        "text": "Define [NOTION 1] and [NOTION 2] with the expected vocabulary."
      },
      {
        "verb": "Explain",
        "text": "Explain the relationship between [NOTION 1] and [NOTION 2]."
      },
      {
        "verb": "Illustrate",
        "text": "Illustrate [NOTION 1] with an example other than that in the course."
      }
    ],
    "moments": [
      {
        "objectives": "Reactivate the above and announce what the session will allow you to understand.",
        "intentions": "A single point of support, formulated as a question: the student must know from the first minute what he will be able to do at the end.",
        "activities": [
          {
            "description": "Entrance question on [PRÉREQUIS 1], two answers collected, announcement of the objective of the session.",
            "instructions": "Write the question on the board and the objective of the session at the top of your page."
          }
        ]
      },
      {
        "objectives": "Install [NOTION 1] and its vocabulary.",
        "intentions": "Presentation interspersed with questions addressed by name: random questioning keeps the whole class engaged.",
        "activities": [
          {
            "description": "Presented on [NOTION 1], supported by [DOCUMENT 1], with three questions asked by name along the way.",
            "instructions": "Make notes in the right column of your sheet. Leave the left column empty for now."
          }
        ]
      },
      {
        "objectives": "Force each student to process the information instead of copying it down.",
        "intentions": "Integration break: Five minutes of individual writing is better than five additional minutes of presentation.",
        "activities": [
          {
            "description": "Writing in three lines of what has just been understood, with reading of two productions aloud.",
            "instructions": "In the left column, summarize in three lines what you have just understood, in your words."
          }
        ]
      },
      {
        "objectives": "Install [NOTION 2] and connect it to [NOTION 1].",
        "intentions": "The second block explicitly concerns the relationship between the two notions: this is where understanding takes place, not in the isolated definition.",
        "activities": [
          {
            "description": "Presentation on [NOTION 2] and its articulation with [NOTION 1], with an explicit counterexample.",
            "instructions": "Note how [NOTION 2] relates to [NOTION 1], and also note the counterexample given."
          }
        ]
      },
      {
        "objectives": "Produce the reference written record of the session.",
        "intentions": "Fill-in-the-blank synthesis rather than dictation: the student must choose the words, which immediately reveals what is not understood.",
        "activities": [
          {
            "description": "Completion of the synthesis with gaps, collectively corrected on the two most missed points.",
            "instructions": "Complete the summary without looking at your notes, then check with your notes by changing color."
          }
        ]
      }
    ]
  },
  "etude-documents": {
    "description": "Analysis session of [DOCUMENT 1] and [DOCUMENT 2] in [MATIÈRE], [NIVEAU]. Students sample, compare, and then write an organized response to [QUESTION].",
    "command": "Program for [MATIÈRE], [NIVEAU]: working [NOTION 1] from documents.",
    "personas": "1) Have relevant information collected. 2) Have a response written based on cited evidence.",
    "outcomes": [
      {
        "verb": "Interpret",
        "text": "Interpret [DOCUMENT 1] taking into account its nature and its author."
      },
      {
        "verb": "Compare",
        "text": "Compare the information of [DOCUMENT 1] and [DOCUMENT 2]."
      },
      {
        "verb": "Write",
        "text": "Write an organized response citing at least two elements taken."
      }
    ],
    "moments": [
      {
        "objectives": "Locate the documents and state the question they will be used to answer.",
        "intentions": "The question is given before reading: without it, students paraphrase instead of taking.",
        "activities": [
          {
            "description": "Presentation of the nature, author and date of each document, then statement of [QUESTION].",
            "instructions": "Note the nature, author and date of each document, then copy [QUESTION] at the top of your sheet."
          }
        ]
      },
      {
        "objectives": "Identify and classify the information useful to the question.",
        "intentions": "Work in pairs with an imposed statement table: the format constraint prevents linear copying of the document.",
        "notes": "Provide a two-column statement table. Circulate and follow up with “what makes you say that?” \".",
        "activities": [
          {
            "description": "Sampling in pairs in [DOCUMENT 1] and [DOCUMENT 2], reported in a two-column table: information noted / what it proves.",
            "instructions": "In pairs, complete the table: in the left column, the exact information from the document; on the right, what it proves to answer the question."
          }
        ]
      },
      {
        "objectives": "Compare the samples and resolve disagreements in interpretation.",
        "intentions": "Disagreements are the material of the moment: they reveal the difference between reading a document and interpreting it.",
        "activities": [
          {
            "description": "Pooling of statements, arbitration of divergent interpretations, construction of the response plan to the table.",
            "instructions": "Announce information that you have noted and what it proves. If you disagree with a classmate, say which passage you rely on."
          }
        ]
      },
      {
        "objectives": "Write an organized and evidence-based response.",
        "intentions": "The writing is individual and marked formatively: it verifies that the collective work has been appropriate.",
        "activities": [
          {
            "description": "Individual writing of a response to [QUESTION] in a structured paragraph, citing at least two samples.",
            "instructions": "Write a paragraph that responds to [QUESTION]. You cite at least two pieces of information from the documents and you specify each time which document they come from."
          }
        ]
      }
    ]
  },
  "modelage-pratique-autonomie": {
    "description": "Explicit teaching session from [MÉTHODE / PROCÉDURE] to [MATIÈRE], [NIVEAU]. The scaffolding is removed in stages: commented demonstration, collective resolution, pairs, then work alone.",
    "command": "Program of [MATIÈRE], [NIVEAU]: master [MÉTHODE / PROCÉDURE].",
    "personas": "1) Make the reasoning of an expert visible. 2) Have each student perform the procedure alone without assistance.",
    "outcomes": [
      {
        "verb": "Describe",
        "text": "Describe the steps of [MÉTHODE / PROCÉDURE] in order."
      },
      {
        "verb": "Run",
        "text": "Run [MÉTHODE / PROCÉDURE] on a simple unaided exercise."
      },
      {
        "verb": "Discriminate",
        "text": "Discriminate situations where [MÉTHODE / PROCÉDURE] applies from those where it does not apply."
      }
    ],
    "moments": [
      {
        "objectives": "Make the reasoning behind each step audible.",
        "intentions": "The teacher verbalizes his decisions and hesitations: it is the reasoning, not the result, which must be made visible.",
        "notes": "Do not question students during this time. Write each step on the board as you go.",
        "activities": [
          {
            "description": "Resolution of [EXEMPLE 1] by the teacher, explaining out loud each decision and possible errors.",
            "instructions": "Listen without writing yet. Identify when I choose between two possibilities."
          }
        ]
      },
      {
        "objectives": "Redo the procedure collectively, step by step, hot-correcting.",
        "intentions": "Each step is validated by the class before moving on to the next: errors are corrected immediately, before being automated.",
        "activities": [
          {
            "description": "Resolution of [EXEMPLE 2] on the board, one step per student questioned, with collective validation at each step.",
            "instructions": "We move forward step by step. Write down each step after validation, and raise your hand as soon as a step seems wrong to you."
          }
        ]
      },
      {
        "objectives": "Practice with the help of a peer before working alone.",
        "intentions": "Intermediate level: the student who explains consolidates, the one who listens receives a reformulation within his or her reach.",
        "activities": [
          {
            "description": "Two exercises handled in pairs, one explains while the other writes, then the roles exchange.",
            "instructions": "In pairs: on the first exercise, one explains and the other writes. You swap roles on the second one."
          }
        ]
      },
      {
        "objectives": "Check that the procedure can be carried out without help.",
        "intentions": "Work alone with correction available at the end of the time: self-correction gives immediate feedback without waiting for the next session.",
        "activities": [
          {
            "description": "Series of application exercises treated alone, followed by self-correction based on the distributed answer key.",
            "instructions": "Do the exercises alone, without help. At the end, correct yourself with the answer key and circle the steps where you made a mistake."
          }
        ]
      }
    ]
  },
  "cours-magistral-sequence": {
    "description": "Dense input session on [NOTION 1] in [MATIÈRE], [NIVEAU], divided into three short blocks. Each block is followed by a five-minute task that checks understanding before continuing.",
    "command": "Program of [MATIÈRE], [NIVEAU]: dense notional content on [NOTION 1].",
    "personas": "1) Convey long content without losing attention. 2) Detect misunderstandings before the end of the session.",
    "outcomes": [
      {
        "verb": "List",
        "text": "List the three constituent elements of [NOTION 1]."
      },
      {
        "verb": "Explain",
        "text": "Explain each of the three elements with an example."
      },
      {
        "verb": "Structuring",
        "text": "Structure your notes by distinguishing definition, example and limit."
      }
    ],
    "moments": [
      {
        "objectives": "Install the first item of [NOTION 1].",
        "intentions": "Twelve minutes of input then five of task: the micro-task is not used to grade but to know if we can continue.",
        "activities": [
          {
            "description": "Contribution to [ÉLÉMENT 1] of [NOTION 1], with an explicit example and limit.",
            "instructions": "Note the definition, example and limit of [ÉLÉMENT 1] in the three columns of your form."
          },
          {
            "description": "Micro-task: an application question on [ÉLÉMENT 1], verified by a show of hands.",
            "instructions": "Answer the projected question in one sentence, then raise your hand according to the answer you chose."
          }
        ]
      },
      {
        "objectives": "Install the second element and connect it to the first.",
        "intentions": "The block opens with the result of the previous micro-task: the input is adjusted to what has not passed.",
        "activities": [
          {
            "description": "Contribution to [ÉLÉMENT 2], articulated to [ÉLÉMENT 1], after resuming the missed question.",
            "instructions": "Note what connects [ÉLÉMENT 2] to [ÉLÉMENT 1]. Underline the word that differentiates between the two."
          },
          {
            "description": "Micro-task in pairs: classify three cases according to whether they fall under one or the other element.",
            "instructions": "With your neighbor, classify the three projected cases. You should be able to justify each ranking in one sentence."
          }
        ]
      },
      {
        "objectives": "Install the third element and complete the assembly.",
        "intentions": "The last block is the shortest and the most concrete: the cognitive load is maximum at the end of the session.",
        "activities": [
          {
            "description": "Contribution to [ÉLÉMENT 3] and recapitulation of the overall architecture of [NOTION 1].",
            "instructions": "Completes the distributed assembly diagram by placing the three elements there."
          }
        ]
      },
      {
        "objectives": "Identify what remains misunderstood before the next session.",
        "intentions": "Anonymous written collection: it gives a precise starting point for the following session and avoids the “does everyone understand?” \".",
        "activities": [
          {
            "description": "Each student writes the most obscure point on a paper; three papers are drawn and processed immediately.",
            "instructions": "Write on a piece of paper, without your name, the point that you least understood. I pull out three papers and we process them right away."
          }
        ]
      }
    ]
  },
  "entrainement-differencie": {
    "description": "Workout on [NOTION 1] in [MATIÈRE], [NIVEAU]. A five-minute diagnosis directs each student to one of three workshops; sharing concerns methods, not results.",
    "command": "Program of [MATIÈRE], [NIVEAU]: consolidate [NOTION 1] with heterogeneous needs.",
    "personas": "1) Give everyone work within their immediate reach. 2) Circulate methods between levels.",
    "outcomes": [
      {
        "verb": "Apply",
        "text": "Apply [NOTION 1] to exercises of increasing difficulty."
      },
      {
        "verb": "Decide",
        "text": "Decide which workshop corresponds to your own mastery level."
      },
      {
        "verb": "Explain",
        "text": "Explain to a friend the method used to solve an exercise."
      }
    ],
    "moments": [
      {
        "objectives": "Situate each student before directing them to a workshop.",
        "intentions": "Two questions are enough: the goal is orientation, not fine measurement. The student then chooses himself, which involves his responsibility.",
        "notes": "Prepare the three workshops in three piles of cards on three separate tables.",
        "activities": [
          {
            "description": "Two questions calibrated on [NOTION 1], corrected immediately on the board, each student situating himself.",
            "instructions": "Answer both questions, then correct yourself on the board. Depending on your result, choose your workshop: the two righteous ones, workshop 3; a fair one, workshop 2; none, workshop 1."
          }
        ]
      },
      {
        "objectives": "Have each student work on tasks adapted to their level of mastery.",
        "intentions": "The three workshops focus on the same concept, with different degrees of support: it is the support that varies, not the objective.",
        "notes": "Stay mainly on workshop 1. Provide an independent answer key for workshops 2 and 3.",
        "activities": [
          {
            "description": "Workshop 1: guided rework with solved example alongside. Workshop 2: standard application exercises. Workshop 3: open issue on [NOTION 1]. The teacher stands near workshop 1.",
            "instructions": "Sit at the table in your workshop. You can change workshops during the session if it is too easy or too difficult. The correction is on the table."
          }
        ]
      },
      {
        "objectives": "Explain and circulate effective procedures.",
        "intentions": "The sharing focuses on “how you did it” and not on “what is the answer”: this is what makes the moment useful on all three levels.",
        "activities": [
          {
            "description": "One student per workshop explains their method; the teacher reveals what is common to the three procedures.",
            "instructions": "One student per workshop explains how he did it. Write down in your notebook the method that seems safest to you."
          }
        ]
      }
    ]
  },
  "resolution-problemes": {
    "description": "Solving session from [PROBLÈME] to [MATIÈRE], [NIVEAU]. Each student first searches alone, then the group compares the approaches; only two groups exhibit, chosen for their different procedures.",
    "command": "Program for [MATIÈRE], [NIVEAU]: mobilize [NOTION 1] in a research situation.",
    "personas": "1) Have it researched before teaching the method. 2) Have several valid approaches compared.",
    "outcomes": [
      {
        "verb": "Solve",
        "text": "Solve [PROBLÈME] by mobilizing [NOTION 1]."
      },
      {
        "verb": "Compare",
        "text": "Compare two resolution approaches and identify the advantages."
      },
      {
        "verb": "Justify",
        "text": "Justify each step of your approach to the class."
      }
    ],
    "moments": [
      {
        "objectives": "Ensure that the situation and the question are understood, without giving any leads.",
        "intentions": "No indication of method: the devolution of the problem assumes that the students search before the teacher teaches.",
        "activities": [
          {
            "description": "Reading of [PROBLÈME] and reformulation by a student of what is sought. No solution is given.",
            "instructions": "Read the problem, then restate out loud what exactly you are looking for. Don't start solving yet."
          }
        ]
      },
      {
        "objectives": "Give everyone time to take a personal approach.",
        "intentions": "Indispensable prior individual time: without it, the group is monopolized by the fastest students.",
        "activities": [
          {
            "description": "Search alone in draft, without exchange. The teacher moves around without responding to requests for validation.",
            "instructions": "Search alone, in rough draft, for ten minutes. Even an incomplete lead is useful: keep your attempts."
          }
        ]
      },
      {
        "objectives": "Compare the options and construct a common reasoned response.",
        "intentions": "The group must produce a single answer: constraint forces argumentation rather than the juxtaposition of drafts.",
        "activities": [
          {
            "description": "Groups of three or four: each presents their idea, the group selects an approach and writes it neatly on a poster.",
            "instructions": "Everyone presents their lead, even incomplete. The group chooses an approach, writes it on the poster, and prepares the justification for each step."
          }
        ]
      },
      {
        "objectives": "Have two different approaches publicly compared.",
        "intentions": "Two groups are enough, chosen for the difference in their procedures: comparison is more formative than repetition.",
        "activities": [
          {
            "description": "Two contrasting posters presented and questioned by the class; the teacher explains the advantage of each procedure.",
            "instructions": "Listen to both steps, then ask a question about the point you missed. Note the procedure that you will use again."
          }
        ]
      },
      {
        "objectives": "Set the reference method and its range of validity.",
        "intentions": "This short moment is essential: without formalization, research remains a memory of activity without stabilized knowledge.",
        "activities": [
          {
            "description": "Formalization by the teacher of the reference method, with its conditions of use.",
            "instructions": "Copies the reference method and the condition which indicates when it can be used."
          }
        ]
      }
    ]
  },
  "revision-avant-evaluation": {
    "description": "Review session from [CHAPITRE] to [MATIÈRE], [NIVEAU], the day before or two days before the evaluation. The students reconstruct the architecture of the chapter before testing themselves.",
    "command": "Program of [MATIÈRE], [NIVEAU]: evaluation of [CHAPITRE] planned for [DATE].",
    "personas": "1) Have the students reconstruct the organization of the chapter. 2) Address the most likely errors before evaluation.",
    "outcomes": [
      {
        "verb": "Recall",
        "text": "Recall without notes the notions and definitions of [CHAPITRE]."
      },
      {
        "verb": "Organize",
        "text": "Organize the concepts of [CHAPITRE] into a hierarchical mental map."
      },
      {
        "verb": "Appreciate",
        "text": "Appreciate your own level of preparation and target what remains to be revised."
      }
    ],
    "moments": [
      {
        "objectives": "Reconstruct from memory the organization of the concepts in the chapter.",
        "intentions": "Active recall without notes: Attempting memory retrieval is more effective than replay, even when it fails.",
        "notes": "Prohibit notebooks and manuals for the first ten minutes, then allow verification.",
        "activities": [
          {
            "description": "Construction of a mental map of [CHAPITRE] in groups of three, first without notes then completed with the notebook in another color.",
            "instructions": "Without your notebooks, build the chapter map in threes. After ten minutes, open the notebook and fill in what is missing in another color."
          }
        ]
      },
      {
        "objectives": "Test rapid restitution and identify collective fragile points.",
        "intentions": "The fun format maintains engagement, but each missed question is noted: the quiz serves as a diagnosis for the next moment.",
        "activities": [
          {
            "description": "Team quiz on [CHAPITRE], one written answer per team and per question; the teacher notes the most missed questions.",
            "instructions": "Only one answer per team, written on the slate. We raise the slate at the signal. Note the questions your team missed."
          }
        ]
      },
      {
        "objectives": "Repeat the two or three most frequent errors from the quiz.",
        "intentions": "Resumption driven by the results of the quiz, not by the chapter plan: we cover what was actually missing.",
        "activities": [
          {
            "description": "Resumption of the most missed questions, with explanation of the confusion which produces them, then announcement of the format of the evaluation.",
            "instructions": "Note the correction of the questions repeated, then write the two points that you still need to revise at home this evening."
          }
        ]
      }
    ]
  },
  "debat-argumente": {
    "description": "Two 55 min sessions on the [CONTROVERSE] controversy in [MATIÈRE], [NIVEAU]. The first prepares the argument file, the second holds the debate and analysis.",
    "command": "Program for [MATIÈRE], [NIVEAU]: work on oral argumentation on [CONTROVERSE].",
    "personas": "1) Build an argument supported by sources. 2) Distinguish an argument from an opinion.",
    "outcomes": [
      {
        "verb": "Explain",
        "text": "Explain the two positions present in [CONTROVERSE]."
      },
      {
        "verb": "Distinguish",
        "text": "Distinguish a supported argument from an unsupported opinion."
      },
      {
        "verb": "Argument",
        "text": "Argument a position based on at least two identified sources."
      },
      {
        "verb": "Criticize",
        "text": "Criticize an opposing argument by targeting the reasoning and not the person."
      }
    ],
    "moments": [
      {
        "objectives": "Ask the debated question and check that it is really debatable.",
        "intentions": "An authentic controversy, with two defensible positions: a false debate produces an empty rhetorical exercise.",
        "notes": "Check that the question does not relate to an established fact. Remember the rules for speaking.",
        "activities": [
          {
            "description": "Presentation of [CONTROVERSE], its issues, and the rules of the debate. Explicit distinction between fact, opinion and argument.",
            "instructions": "Note the debate question and the three rules for speaking. Also write, for yourself alone, the position that you would spontaneously have."
          }
        ]
      },
      {
        "objectives": "Construct an argument supported by verifiable sources.",
        "intentions": "Camps are assigned, not chosen: defending a position that one does not share requires understanding the other reasoning.",
        "activities": [
          {
            "description": "Search in groups in [CORPUS / SOURCES], with imposed argument sheet: assertion, proof, source, predictable objection.",
            "instructions": "Your camp is assigned to you. Create four argument cards: the assertion, the proof, the precise source, and the objection that the other side will make to you."
          }
        ]
      },
      {
        "objectives": "Organize the speech and prepare the order of interventions.",
        "intentions": "Named roles — spokesperson, responder, observer — ensure that all students have a task during the game.",
        "activities": [
          {
            "description": "Assignment in each camp of the roles of spokesperson, respondent and observer, with order of presentation of the arguments.",
            "instructions": "Divide the roles: two spokespersons, two respondents, the rest as observers with the observation grid."
          }
        ]
      },
      {
        "objectives": "Hold the debate while respecting the framework and responding to opposing arguments.",
        "intentions": "The speaking time is timed and the teacher does not decide the substance: his role is to ensure that the framework is respected.",
        "notes": "Visible stopwatch. Write down on the board the arguments actually exchanged for the metacognitive feedback.",
        "activities": [
          {
            "description": "Debate in three rounds: presentation of positions, cross-responses, conclusions. The observers fill in the grid.",
            "instructions": "Two minutes per speech. You always start by reformulating the argument you are responding to. Observers: fill in the grid."
          }
        ]
      },
      {
        "objectives": "Analyze what made some arguments more convincing than others.",
        "intentions": "The decisive moment: we do not evaluate who won but which processes won support, and which were not arguments.",
        "activities": [
          {
            "description": "Voting by secret ballot, then collective analysis of the three most effective arguments and the two weakest, supporting observation grid.",
            "instructions": "Vote for the position that most convinced you, even if it is not your side. Then say which argument made you change your mind, and why."
          }
        ]
      }
    ]
  },
  "expose-eleve": {
    "description": "Presentation session on [SUJETS D’EXPOSÉ] in [MATIÈRE], [NIVEAU]. Preparation takes place outside of class with the evaluation grid known in advance; the teacher repeats the content after the passages.",
    "command": "Program for [MATIÈRE], [NIVEAU]: work on speaking continuously on [SUJETS D’EXPOSÉ].",
    "personas": "1) Have a structured and sourced presentation produced. 2) Have the rest of the class actively listen to the presentations.",
    "outcomes": [
      {
        "verb": "Design",
        "text": "Design a structured presentation of [DURÉE EXPOSÉ] on [SUJET]."
      },
      {
        "verb": "Use",
        "text": "Use a visual support that supports the point without duplicating it."
      },
      {
        "verb": "Evaluate",
        "text": "Evaluate a presentation using a criterion-referenced grid."
      }
    ],
    "moments": [
      {
        "objectives": "Produce a structured, sourced and timed presentation.",
        "intentions": "The assessment grid is provided with the subject: the student must know what they will be assessed on before starting.",
        "notes": "Distribute the grid when assigning subjects, at least two weeks before.",
        "activities": [
          {
            "description": "Preparation of the out-of-class presentation: plan, visual support, sources identified, timing. The criteria grid is provided upon assignment of the subject.",
            "instructions": "Prepare your presentation of [DURÉE EXPOSÉ]: a plan in three parts, a simple support, your sources indicated. Repeat out loud at least once while timing yourself."
          }
        ]
      },
      {
        "objectives": "Exhibit in front of the class while respecting the framework and time.",
        "intentions": "Listeners have a written task during passages: without it, the presentation only concerns the speaker.",
        "activities": [
          {
            "description": "Three presentations by [DURÉE EXPOSÉ], each followed by a question from the class. The listeners complete the grid and the note sheet.",
            "instructions": "During each presentation, fill in the grid and write down the two pieces of information you remember. Prepare a question to ask."
          }
        ]
      },
      {
        "objectives": "Compare the evaluations and explain the success criteria.",
        "intentions": "Comparing the grids reveals disagreements in the interpretation of the criteria, which refines them for everyone.",
        "activities": [
          {
            "description": "Comparison of the grids in groups of three, then oral restitution of a strong point and an area of ​​progress by presentation.",
            "instructions": "Compare your three grids. For each presentation, formulate a specific strong point and an area of ​​progress formulated as advice."
          }
        ]
      },
      {
        "objectives": "Validate, correct and complete the contents presented.",
        "intentions": "Essential moment: without retakes, errors in the content of the presentations remain in the students' grades.",
        "activities": [
          {
            "description": "Rectification of inaccuracies noted and provision of elements not covered by the presentations.",
            "instructions": "Correct your notes based on what is corrected, and add the elements that were not presented."
          }
        ]
      }
    ]
  },
  "jeu-de-role": {
    "description": "Simulation of [SITUATION SIMULÉE] into [MATIÈRE], [NIVEAU]. Each delegation defends a documented position; the final debriefing makes the link between the fiction and the content of the program.",
    "command": "Program for [MATIÈRE], [NIVEAU]: understand the positions in play in [SITUATION SIMULÉE].",
    "personas": "1) Make a system of actors understood from the inside. 2) Have a position defended according to imposed constraints.",
    "outcomes": [
      {
        "verb": "Explain",
        "text": "Explain the interests defended by each actor in [SITUATION SIMULÉE]."
      },
      {
        "verb": "Use",
        "text": "Use the vocabulary and constraints specific to the assigned role."
      },
      {
        "verb": "Assign",
        "text": "Assign a position to the actor who defends it and explain why."
      },
      {
        "verb": "Judge",
        "text": "Judge what the simulation faithfully reproduces and what it simplifies."
      }
    ],
    "moments": [
      {
        "objectives": "Assign roles and make everyone’s constraints understood.",
        "intentions": "Each file contains a non-negotiable constraint: it is this which prevents the simulation from turning into a debate of opinions.",
        "notes": "Prepare a file by role: interests, non-negotiable constraint, two figures.",
        "activities": [
          {
            "description": "Presentation of [SITUATION SIMULÉE], the process and the roles. Submission of a file by delegation.",
            "instructions": "Read your file: what your actor wants to achieve, and the constraint he cannot overcome. You play this role, not your opinion."
          }
        ]
      },
      {
        "objectives": "Build the delegation's position and its speaking strategy.",
        "intentions": "The delegation must anticipate opposing positions: it is this anticipation which produces the understanding of the system of actors.",
        "activities": [
          {
            "description": "Preparation in delegations: opening position, two numerical arguments, red line, anticipation of adversaries.",
            "instructions": "Prepare your opening statement in one minute, two arguments with numbers, and what you will refuse to give in."
          }
        ]
      },
      {
        "objectives": "Run the simulation while respecting the roles and protocol.",
        "intentions": "The teacher chairs the session and not arbitrates on substance: he ensures that speaking turns and time are respected.",
        "activities": [
          {
            "description": "Happened in three stages: opening statements, supervised free exchanges, attempted agreement or verdict.",
            "instructions": "Stay in your role until the end. You are addressing other delegations, not me. Note what others get from you."
          }
        ]
      },
      {
        "objectives": "Make the link between simulation and program content.",
        "intentions": "Without debriefing, the simulation remains a game: this is where the students step out of the role and name the knowledge worked on.",
        "activities": [
          {
            "description": "Explicit role exit, then uncovering the real mechanisms that the simulation reproduced and what it simplified.",
            "instructions": "You leave your role. Say one thing you understood while playing this character, and one thing the simulation made too simple."
          }
        ]
      }
    ]
  },
  "cercle-lecture": {
    "description": "Chat session from [TEXTE] to [MATIÈRE], [NIVEAU]. The discussion is held according to a strict speaking protocol; it closes with a personal writing.",
    "command": "Program for [MATIÈRE], [NIVEAU]: interpret [TEXTE] and compare the readings.",
    "personas": "1) Have an interpretation formulated based on the text. 2) Have others listen to and take up the words of others.",
    "outcomes": [
      {
        "verb": "Interpret",
        "text": "Interpret a passage from [TEXTE] based on its words."
      },
      {
        "verb": "Question",
        "text": "Question an interpretation by citing the text."
      },
      {
        "verb": "Formulate",
        "text": "Formulate in writing a personal position informed by the discussion."
      }
    ],
    "moments": [
      {
        "objectives": "Return to the text with the discussion question in mind.",
        "intentions": "Proofreading is silent and equipped: without a passage identified, the discussion slides towards the exchange of general opinions.",
        "activities": [
          {
            "description": "Silent rereading of [TEXTE] with identification of two passages linked to [QUESTION DE DISCUSSION].",
            "instructions": "Reread the text and highlight two passages that seem useful to you in answering the question. Side note why."
          }
        ]
      },
      {
        "objectives": "Confront interpretations based on the text.",
        "intentions": "Strict protocol: you only speak after repeating what the previous person has said, which forces real listening.",
        "notes": "Arrange the tables in a circle. The teacher does not validate the interpretations, he asks “where do you see it?” \".",
        "activities": [
          {
            "description": "Circle discussion on [QUESTION DE DISCUSSION]: each intervention repeats the previous one and quotes a passage.",
            "instructions": "Before giving your opinion, rephrase what the previous person said. Then cite the passage you are relying on."
          }
        ]
      },
      {
        "objectives": "Establish in writing a personal position nourished by discussion.",
        "intentions": "The final writing individualizes the benefit of the discussion and leaves an evaluable trace of the thinking of each student.",
        "activities": [
          {
            "description": "Individual writing of a reasoned response to [QUESTION DE DISCUSSION], mentioning a contribution from the discussion.",
            "instructions": "Write your answer in one paragraph. Quote a passage from the text, and indicate an idea from a friend that modified your reading."
          }
        ]
      }
    ]
  },
  "tache-complexe": {
    "description": "Two 55 min sessions dedicated to [MISSION] in [MATIÈRE], [NIVEAU]. The groups have the success criteria from the start and present their production to another group before self-evaluating.",
    "command": "Program for [MATIÈRE], [NIVEAU]: mobilize [NOTION 1] and [NOTION 2] in a production.",
    "personas": "1) Use several concepts in the same task. 2) Develop cooperation and distribution of work.",
    "outcomes": [
      {
        "verb": "Implement",
        "text": "Implement [NOTION 1] and [NOTION 2] in joint production."
      },
      {
        "verb": "Develop",
        "text": "Develop [PRODUCTION ATTENDUE] consistent with announced success criteria."
      },
      {
        "verb": "Evaluate",
        "text": "Evaluate your production using the success criteria."
      },
      {
        "verb": "Organize",
        "text": "Organize the work of the group into distributed and maintained tasks."
      }
    ],
    "moments": [
      {
        "objectives": "Understand what is expected and how success will be recognized.",
        "intentions": "The criteria are given before production, never after: without them, the students work blindly and the evaluation seems arbitrary.",
        "notes": "Post success criteria on the board for the duration of the project.",
        "activities": [
          {
            "description": "Introducing [MISSION], [PRODUCTION ATTENDUE] and the four success criteria, with an example of successful production.",
            "instructions": "Note the mission and the four success criteria. Look at the projected example: identify what makes it conform to the criteria."
          }
        ]
      },
      {
        "objectives": "Distribute tasks and set internal group deadlines.",
        "intentions": "Written planning makes cooperation verifiable and makes it possible to identify groups in difficulty from the first session.",
        "activities": [
          {
            "description": "Filling out a project sheet by group: tasks, responsible for each task, deadlines, necessary resources.",
            "instructions": "Fill out the project form: who does what, by when. Each group member should have a named task."
          }
        ]
      },
      {
        "objectives": "Create [PRODUCTION ATTENDUE] while respecting the criteria.",
        "intentions": "The teacher only intervenes on request and systematically refers to the criteria displayed rather than the solution.",
        "activities": [
          {
            "description": "Realization of [PRODUCTION ATTENDUE] in groups, with mid-term progress report led by the teacher.",
            "instructions": "Produce according to your project sheet. Halfway through, check your progress against the four criteria displayed."
          }
        ]
      },
      {
        "objectives": "Present your production to another group and receive criterion-referenced feedback.",
        "intentions": "Presentation in pairs of groups rather than in front of the whole class: everyone really presents and the speaking time is multiplied.",
        "activities": [
          {
            "description": "Each group presents to another group, who gives feedback structured by the four success criteria.",
            "instructions": "Present your production to the group in front of you in five minutes. The listening group responds criterion by criterion."
          }
        ]
      },
      {
        "objectives": "Situate your production and identify what remains to be improved.",
        "intentions": "Criterion-referenced self-assessment after feedback from peers is more lucid and prepares the grade awarded by the teacher.",
        "activities": [
          {
            "description": "Positioning of the group on each criterion with written justification, then identification of a point for improvement.",
            "instructions": "Position your production on each criterion and justify it in one sentence. Write down the first thing you would correct with another hour."
          }
        ]
      }
    ]
  },
  "ecriture-guidee": {
    "description": "Writing session from [TYPE D’ÉCRIT] to [MATIÈRE], [NIVEAU]. The text goes through an analyzed model, a draft, a peer review and an actual rewriting in class.",
    "command": "Program for [MATIÈRE], [NIVEAU]: master the writing of [TYPE D’ÉCRIT].",
    "personas": "1) Make people perceive the characteristics of the expected genre. 2) Actually rewrite, not just draft.",
    "outcomes": [
      {
        "verb": "Analyze",
        "text": "Analyze an example of [TYPE D’ÉCRIT] to identify its characteristics."
      },
      {
        "verb": "Write",
        "text": "Write a [TYPE D’ÉCRIT] conforming to the identified criteria."
      },
      {
        "verb": "Criticize",
        "text": "Criticize a peer’s text based on explicit criteria."
      },
      {
        "verb": "Modify",
        "text": "Modify its text based on the comments received."
      }
    ],
    "moments": [
      {
        "objectives": "Identify the characteristics of the type to be produced.",
        "intentions": "Start with a successful text and have the students name what makes it successful: the criteria grid is thus constructed, not imposed.",
        "activities": [
          {
            "description": "Pair analysis of [EXEMPLE EXPERT]: identification of the structure, language marks, length, then pooled in the form of criteria.",
            "instructions": "In pairs, identify how this text is constructed: how many parts, what connecting words, what length. You propose three criteria for the class."
          }
        ]
      },
      {
        "objectives": "Organize your ideas before writing.",
        "intentions": "The plan is validated before writing: correcting an organization takes two minutes, correcting an entire text takes twenty.",
        "activities": [
          {
            "description": "Writing a plan then a first draft of [TYPE D’ÉCRIT] on [SUJET D’ÉCRITURE]. The teacher validates the plans while circulating.",
            "instructions": "First write your plan in three lines and have it validated. Then write your first draft without stopping on spelling."
          }
        ]
      },
      {
        "objectives": "Receive precise feedback, based on the constructed criteria.",
        "intentions": "The proofreader does not correct: he signals using the criteria, which leaves responsibility for the text to its author.",
        "activities": [
          {
            "description": "Exchange of drafts in pairs, annotation based on the criteria, then three minutes of oral feedback via text.",
            "instructions": "Read your friend's text using the grid. You do not correct: you point out where a criterion is not respected and you explain orally."
          }
        ]
      },
      {
        "objectives": "Produce a second version which incorporates the feedback.",
        "intentions": "Rewriting takes place in class, not at home: it is the gesture that we seek to teach and it must be accompanied.",
        "activities": [
          {
            "description": "Second version written taking into account the comments, with explicit mention of the two most important modifications.",
            "instructions": "Rewrite your text taking into account the comments. At the bottom of the page, write down the two most important changes you made."
          }
        ]
      }
    ]
  },
  "production-mediatique": {
    "description": "Project of three sessions: create [PRODUCTION MÉDIATIQUE] on [SUJET] in [MATIÈRE], [NIVEAU]. The genre is first analyzed, the production is scripted before being produced, then broadcast to a real audience.",
    "command": "Program of [MATIÈRE], [NIVEAU]: process [SUJET] and work on media education.",
    "personas": "1) Have media produced that complies with the codes of its genre. 2) Verify and cite the sources used.",
    "outcomes": [
      {
        "verb": "Analyze",
        "text": "Analyze [PRODUCTION MÉDIATIQUE] codes from professional examples."
      },
      {
        "verb": "Design",
        "text": "Design the scenario of [PRODUCTION MÉDIATIQUE] on [SUJET]."
      },
      {
        "verb": "Use",
        "text": "Use the necessary production and editing tools."
      },
      {
        "verb": "Justify",
        "text": "Justify your editorial choices and the treatment of your sources."
      }
    ],
    "moments": [
      {
        "objectives": "Identify the media codes to produce.",
        "intentions": "We only produce a genre that we have first dismantled: two professional examples analyzed are better than a format instruction.",
        "notes": "Select two contrasting professional examples of [PRODUCTION MÉDIATIQUE].",
        "activities": [
          {
            "description": "Analysis of two professional examples: duration, structure, tone, place of sources. Collective construction of the production grid.",
            "instructions": "In groups of three, analyze the two examples: how long, what parts, what tone, how the sources are cited. You propose three rules for our production."
          }
        ]
      },
      {
        "objectives": "Write the scenario or storyboard before any production.",
        "intentions": "Production does not begin before validation of the scenario: without this step, students repeat takes indefinitely without progressing.",
        "activities": [
          {
            "description": "Writing of the scenario or storyboard of [PRODUCTION MÉDIATIQUE], with sources identified for each statement. Validation by the teacher.",
            "instructions": "Write your timed scenario. For each claim you make, note the source next to it. Validate before moving on to production."
          }
        ]
      },
      {
        "objectives": "Carry out production in accordance with the validated scenario.",
        "intentions": "The technical roles are assigned by name to prevent the production from being monopolized by a single student in the group.",
        "activities": [
          {
            "description": "Registration, editing or layout of [PRODUCTION MÉDIATIQUE] with [OUTIL DE PRODUCTION], distributed technical roles.",
            "instructions": "Carry out your production following the validated scenario. Everyone plays their technical role. Save and name your file according to the instructions."
          }
        ]
      },
      {
        "objectives": "Confront the production to an audience and gather their reactions.",
        "intentions": "Dissemination to a real audience changes the level of requirements: it is the reason why the project is better than an exercise.",
        "activities": [
          {
            "description": "Broadcast of productions in front of [PUBLIC VISÉ], with feedback structured by the grid constructed in session 1.",
            "instructions": "Present your production. During the other presentations, fill out the grid and note an achievement to remember for next time."
          }
        ]
      },
      {
        "objectives": "Take stock of editorial choices and technical difficulties.",
        "intentions": "The assessment separates what is content and what is technical: students often confuse the two in their self-assessment.",
        "activities": [
          {
            "description": "Return to the choices of treatment of the subject, the verification of sources and the technical obstacles encountered.",
            "instructions": "Tell us about an editorial choice that you are satisfied with, a source that you excluded and why, and a technical difficulty that you know how to avoid."
          }
        ]
      }
    ]
  },
  "demarche-investigation": {
    "description": "Investigation session on [PHÉNOMÈNE ÉTUDIÉ] in [MATIÈRE], [NIVEAU]. Students formulate hypotheses, design the protocol, measure then conclude by comparing hypothesis and result.",
    "command": "Program for [MATIÈRE], [NIVEAU]: explain [PHÉNOMÈNE ÉTUDIÉ] using the experimental approach.",
    "personas": "1) Build a testable hypothesis. 2) Have a protocol designed that isolates the variable studied.",
    "outcomes": [
      {
        "verb": "Formulate",
        "text": "Formulate a testable hypothesis about [PHÉNOMÈNE ÉTUDIÉ]."
      },
      {
        "verb": "Design",
        "text": "Design a protocol that varies only one parameter."
      },
      {
        "verb": "Run",
        "text": "Run the protocol and take the measurements with the correct unit."
      },
      {
        "verb": "Conclude",
        "text": "Conclude by comparing the results obtained with the initial hypothesis."
      }
    ],
    "moments": [
      {
        "objectives": "Raising a question that cannot be answered by observation alone.",
        "intentions": "The situation must resist: if the explanation is immediately available, the experience becomes a simple illustration.",
        "activities": [
          {
            "description": "Introducing [PHÉNOMÈNE ÉTUDIÉ] as a surprising observation or counter-intuitive result.",
            "instructions": "Observe and note the question this poses. No explanation yet."
          }
        ]
      },
      {
        "objectives": "Generate testable hypotheses and write them on the board.",
        "intentions": "All hypotheses are written, including false ones: they will be compared with the results, which gives meaning to the measurement.",
        "activities": [
          {
            "description": "Formulation by groups of hypotheses in “if… then…” format, all reported in the table without validation.",
            "instructions": "In groups of three, write your hypothesis in the form “if… then…”. It must be able to be verified by an experiment."
          }
        ]
      },
      {
        "objectives": "Design an experiment that tests the hypothesis by isolating a variable.",
        "intentions": "This is the most educational moment and most often overlooked: giving the protocol ready-made removes most of the process.",
        "notes": "Validate each protocol before handling, by checking the indicator and the isolated variable.",
        "activities": [
          {
            "description": "Drafting of the protocol by group: equipment, variable tested, control, measurements to be taken. Validation by the teacher before handling.",
            "instructions": "Write your protocol: the material, what you vary, what you keep the same, what you measure. Validate before handling."
          }
        ]
      },
      {
        "objectives": "Carry out the experiment and take the measurements rigorously.",
        "intentions": "The results are recorded in a table given in advance: the rigor of the reading determines the interpretation.",
        "activities": [
          {
            "description": "Carrying out the experiment and recording the measurements in a table, with safety instructions recalled.",
            "instructions": "Carry out the experiment and fill in the measurement table, with the units. Also note what did not go as planned."
          }
        ]
      },
      {
        "objectives": "Compare the results with the hypotheses and write the conclusion.",
        "intentions": "We return explicitly to the hypotheses written on the board: a disconfirmed hypothesis is a result, not a failure.",
        "activities": [
          {
            "description": "Individual writing of the conclusion, taking up the initial hypothesis and the result obtained, with the limits of the experiment.",
            "instructions": "Write your conclusion: recall the hypothesis, say whether it is confirmed or not, and indicate a limitation of the experiment."
          }
        ]
      }
    ]
  },
  "recherche-documentaire": {
    "description": "Research session on [QUESTION DE RECHERCHE] in [MATIÈRE], [NIVEAU], one position per pair. Students must cross-reference two independent sources and justify their reliability.",
    "command": "Media and information education: search, verify and reference information on [QUESTION DE RECHERCHE].",
    "personas": "1) Build an efficient query. 2) Have the reliability of a source assessed and cite it correctly.",
    "outcomes": [
      {
        "verb": "Use",
        "text": "Use relevant keywords to build a query."
      },
      {
        "verb": "Distinguish",
        "text": "Distinguish an institutional source from opinion or promotional content."
      },
      {
        "verb": "Evaluate",
        "text": "Evaluate the reliability of a source by crossing two independent references."
      },
      {
        "verb": "Write",
        "text": "Write a summary sheet correctly citing your sources."
      }
    ],
    "moments": [
      {
        "objectives": "Transform a vague subject into a precise question and keywords.",
        "intentions": "The quality of the research depends almost entirely on the initial formulation: this framing time is not a waste of time.",
        "activities": [
          {
            "description": "Decomposition of [QUESTION DE RECHERCHE] into three keywords, with demonstration on the board of two queries of unequal quality.",
            "instructions": "Write the question, then the three keywords you are going to use. Compare with the projected query: which is more precise?"
          }
        ]
      },
      {
        "objectives": "Collect information while systematically preserving its origin.",
        "intentions": "The collection table requires you to note the source at the same time as the information: added after the fact, it is always approximate.",
        "notes": "One station per pair. Prohibit copying and pasting without mention of the URL and date of consultation.",
        "activities": [
          {
            "description": "Research in pairs, collected in a table with three columns: information / precise source / date of consultation.",
            "instructions": "In pairs, complete the table. No information without its exact source and date. You need to find two different sources for each important piece of information."
          }
        ]
      },
      {
        "objectives": "Compare the sources and justify a verdict of reliability.",
        "intentions": "We evaluate the source, not just the information: who publishes, for what purpose, with what evidence. The disagreement between pairs is exploited.",
        "activities": [
          {
            "description": "Pooling of sources found, collective classification by reliability, with justification by the author, the intention and the evidence provided.",
            "instructions": "Announce a source you used and say why you trust it: who publishes, for what purpose, with what evidence."
          }
        ]
      },
      {
        "objectives": "Produce a short, accurate and correctly referenced summary.",
        "intentions": "The length constraint requires prioritization: an unlimited synthesis becomes copy and paste again.",
        "activities": [
          {
            "description": "Writing a summary sheet of ten lines maximum responding to [QUESTION DE RECHERCHE], with bibliography of two sources.",
            "instructions": "Write ten lines maximum that answer the question, in your own words. At the bottom, cite your two sources: author, title, site, date."
          }
        ]
      }
    ]
  },
  "evaluation-correction-active": {
    "description": "Evaluation of [CHAPITRE] in [MATIÈRE], [NIVEAU], followed by an active correction session where students classify their own errors before correcting them in workshops.",
    "command": "Program of [MATIÈRE], [NIVEAU]: evaluate the achievements of [CHAPITRE].",
    "personas": "1) Measure achievement reliably. 2) Make correction a moment of learning and not of distributing grades.",
    "outcomes": [
      {
        "verb": "Apply",
        "text": "Apply the concepts of [CHAPITRE] in the assessment exercises."
      },
      {
        "verb": "Examine",
        "text": "Examine its copy to classify its errors by type."
      },
      {
        "verb": "Decide",
        "text": "Decide on the two points to rework as a priority."
      }
    ],
    "moments": [
      {
        "objectives": "Measure the achievements of [CHAPITRE] under fair conditions.",
        "intentions": "The scale is indicated on the subject and the types of exercises are those worked in class: the evaluation verifies the teaching, it does not go beyond it.",
        "notes": "Provide a subject designed for students with special needs. Scale visible on the subject.",
        "activities": [
          {
            "description": "Written assessment on [CHAPITRE]: restitution, application and a reasoning question, scale announced.",
            "instructions": "Works alone, without documents. The scale is indicated next to each question: start with what you know how to do."
          }
        ]
      },
      {
        "objectives": "Classify your errors by type to understand their origin.",
        "intentions": "Classification by type — reading instructions, missing knowledge, method error, inattention — transforms the note into usable information.",
        "activities": [
          {
            "description": "Each student takes their copy and classifies their errors into four categories: incorrectly read instructions, missing knowledge, method, inattention.",
            "instructions": "Go back to your copy and classify each error in one of the four boxes. Count how many you have in each box."
          }
        ]
      },
      {
        "objectives": "Rework what failed, depending on the type of error made.",
        "intentions": "The workshops are organized by type of error, not by grade: two students of different levels can share the same method difficulty.",
        "activities": [
          {
            "description": "Three remediation workshops corresponding to the most frequent errors, each student joining that of their dominant category.",
            "instructions": "Join the workshop that corresponds to the box where you have the most errors. Repeat the failed exercise in its corrected version."
          }
        ]
      },
      {
        "objectives": "Formulate two specific personal objectives for the next chapter.",
        "intentions": "Only two objectives, written and verifiable: a long progress plan is never reread.",
        "activities": [
          {
            "description": "Writing in the notebook two verifiable personal objectives, reread at the start of the next session.",
            "instructions": "Write two objectives for the next evaluation, formulated in a verifiable way, such as “I reread the instructions before answering”."
          }
        ]
      }
    ]
  },
  "bilan-metacognitif": {
    "description": "Half session of 30 min at the end of [SÉQUENCE]. The students position themselves on each of the achievements announced at the beginning, write down what resists, then exchange their work strategies.",
    "command": "Program of [MATIÈRE], [NIVEAU]: closing of [SÉQUENCE].",
    "personas": "1) Make people aware of how far they have come. 2) Circulate effective learning strategies among students.",
    "outcomes": [
      {
        "verb": "Appreciate",
        "text": "Appreciate your level of mastery on each of the achievements of [SÉQUENCE]."
      },
      {
        "verb": "Examine",
        "text": "Examine the way it works and identify a weak point."
      },
      {
        "verb": "Explain",
        "text": "Explain to the class a work strategy that worked."
      }
    ],
    "moments": [
      {
        "objectives": "Reread the acquired knowledge targeted at the beginning of the sequence.",
        "intentions": "The assessment is based on the achievements actually announced: this is what makes the educational contract readable from start to finish.",
        "activities": [
          {
            "description": "Projection of the achievements announced at the start of [SÉQUENCE] and reminder of the main activities carried out.",
            "instructions": "Reread the skills displayed at the beginning of the sequence. For each one, be prepared to say where you stand."
          }
        ]
      },
      {
        "objectives": "Precisely locate your level of mastery on each achievement.",
        "intentions": "Written and individual positioning before any exchange: the neighbor's opinion strongly distorts the self-evaluation when it is public.",
        "activities": [
          {
            "description": "Positioning on a four-level scale for each achievement, with the obligation to cite concrete proof for each mastered achievement.",
            "instructions": "Position yourself on each achievement. For each skill you claim to have mastered, cite a specific exercise that proves it."
          }
        ]
      },
      {
        "objectives": "Explain what has been understood and what still resists.",
        "intentions": "A short writing in two parts: what is acquired, what resists. The second part is the real material for the next sequence.",
        "activities": [
          {
            "description": "Writing in two paragraphs: what I understood and which will be useful to me, what resists and how I will go about it.",
            "instructions": "Write two paragraphs: “what I have understood and which will help me” and “what resists, and what I will do to get there”."
          }
        ]
      },
      {
        "objectives": "Circulate the ways of working that have worked.",
        "intentions": "It is the students' strategies, not those of the teacher, which are admissible here: they are credible and immediately imitable.",
        "activities": [
          {
            "description": "Three students demonstrate a working method that really served them during the sequence.",
            "instructions": "If you have found a method that works for you, describe it in two sentences. Write down the one from a friend that you are going to try."
          }
        ]
      }
    ]
  },
  "evaluation-par-les-pairs": {
    "description": "Cross-assessment session from [PRODUCTION ÉVALUÉE] to [MATIÈRE], [NIVEAU]. The grid is first tested collectively on an example, before being applied to the class's productions.",
    "command": "Program for [MATIÈRE], [NIVEAU]: evaluate [PRODUCTION ÉVALUÉE] using explicit criteria.",
    "personas": "1) Make the criteria understood by applying them. 2) Improve your production after feedback from a peer.",
    "outcomes": [
      {
        "verb": "Interpret",
        "text": "Interpret each criterion in the grid on a concrete example."
      },
      {
        "verb": "Evaluate",
        "text": "Evaluate the production of a peer by justifying each level assigned."
      },
      {
        "verb": "Modify",
        "text": "Modify own production based on feedback received."
      }
    ],
    "moments": [
      {
        "objectives": "Understand each criterion by applying it to a common example.",
        "intentions": "An untested rubric produces inconsistent evaluations: this initial calibration is what makes peer evaluation reliable.",
        "notes": "Use an anonymous example, preferably from another class or a previous year.",
        "activities": [
          {
            "description": "Collective evaluation of an anonymous example with the grid, discussing the differences in scoring criterion by criterion.",
            "instructions": "Note the projected example with the grid, alone first. We then compare: on which criterion do our opinions differ the most?"
          }
        ]
      },
      {
        "objectives": "Evaluate the production of a peer by justifying each level.",
        "intentions": "The obligation to justify in writing each assigned level prevents the convenience assessment as well as the punitive assessment.",
        "activities": [
          {
            "description": "Cross-assessment in pairs with the grid, each level awarded must be justified by a specific element of production.",
            "instructions": "Evaluate your friend's production criterion by criterion. For each level, write the specific element that made you choose this level."
          }
        ]
      },
      {
        "objectives": "Formulate usable feedback, oriented towards improvement.",
        "intentions": "The imposed format – a strong point, actionable advice – protects the author and makes the feedback usable.",
        "activities": [
          {
            "description": "Oral feedback in pairs, according to the imposed format: a specific strong point, then advice formulated as an action to be taken.",
            "instructions": "Tell your friend a specific strong point, then some advice that begins with an action verb. No overall judgment."
          }
        ]
      },
      {
        "objectives": "Immediately modify its production upon return received.",
        "intentions": "Without in-class recovery time, peer assessment changes nothing: this short step is what makes it useful.",
        "activities": [
          {
            "description": "Immediate resumption of production at the point indicated, with mention of the change made.",
            "instructions": "Immediately correct the point pointed out by your friend, and note in the margin what you have changed."
          }
        ]
      }
    ]
  },
  "ia-generative-encadree": {
    "description": "55 min session on [TÂCHE] in [MATIÈRE], [NIVEAU], one station per student. The student first produces without AI, then improves with AI by keeping track of his prompts, and finally justifies his choices.",
    "command": "Reasoned and documented use of generative AI in [MATIÈRE]. AIAS level announced and verifiable.",
    "personas": "1) Make the use of AI visible and debatable. 2) Have the real added value of the assistance assessed.",
    "outcomes": [
      {
        "verb": "Produce",
        "text": "Produce a first version of [TÂCHE] without any assistance."
      },
      {
        "verb": "Use",
        "text": "Use a precise prompt and keep track of your exchanges."
      },
      {
        "verb": "Compare",
        "text": "Compare its initial version and its assisted version point by point."
      },
      {
        "verb": "Justify",
        "text": "Justify each AI proposition retained or rejected."
      }
    ],
    "moments": [
      {
        "objectives": "Know exactly what is allowed, what is prohibited and what must be traced.",
        "intentions": "The AIAS level is announced and written: without an explicit framework, the use of AI is regulated according to what each student believes is tolerated.",
        "notes": "Display the AIAS level for the session on the board. Remember that the prompt log will be noted.",
        "activities": [
          {
            "description": "Announcement of the AIAS level of the session, what is authorized, and the format of the prompt log that will be returned.",
            "instructions": "Note the level of use authorized today and what you will have to submit: your first version, your prompt log, your final version."
          }
        ]
      },
      {
        "objectives": "Produce a first personal version, without any assistance.",
        "intentions": "The version without AI is the benchmark for comparison and proof of personal work: without it, no progress is measurable.",
        "activities": [
          {
            "description": "Writing a first version of [TÂCHE], recorded and timestamped before any use of the AI.",
            "instructions": "Produce your first version alone, without AI. Save it under the name “v1” before continuing: it will no longer be modified."
          }
        ]
      },
      {
        "objectives": "Improve your production with AI by keeping track of exchanges.",
        "intentions": "The prompt journal shifts attention from the result to the process: it is this which makes the use evaluable.",
        "activities": [
          {
            "description": "Improved version 1 with [OUTIL IA], each prompt and each decision (retain/discard) being logged in a log.",
            "instructions": "Improve your v1 with AI. For each exchange, copy your prompt in the newspaper and note whether you accept or reject the proposal, and why."
          }
        ]
      },
      {
        "objectives": "Measure the real contribution of assistance and defend your choices.",
        "intentions": "The discussion concerns the proposals rejected as much as those retained: this is where the student's judgment can be read.",
        "activities": [
          {
            "description": "Collective confrontation of versions 1 and 2, with justification of two proposals retained and one proposal rejected.",
            "instructions": "Showcase one thing that AI has actually improved, and one thing you declined and why."
          }
        ]
      }
    ]
  },
  "esprit-critique-ia": {
    "description": "55 min session, one station per student with access to [OUTIL IA]. Students test the probabilistic nature of a language model, verify the sources of a generated response, then construct a four-step verification protocol.",
    "command": "Media and information education: critical thinking regarding AI-generated content.",
    "personas": "1) Make people understand the probabilistic functioning of a language model. 2) Train a method of verifying and crossing sources.",
    "outcomes": [
      {
        "verb": "Explain",
        "text": "Explain that a language model predicts the most likely word and does not verify what it asserts."
      },
      {
        "verb": "Distinguish",
        "text": "Distinguish, in an AI response, verifiable assertions from non-existent sources."
      },
      {
        "verb": "Apply",
        "text": "Apply a four-step verification protocol to generated assertions."
      },
      {
        "verb": "Evaluate",
        "text": "Evaluate the reliability of information by crossing two independent sources."
      },
      {
        "verb": "Write",
        "text": "Write a personal verification protocol sheet."
      }
    ],
    "moments": [
      {
        "objectives": "Bring out initial representations and identify misconceptions.",
        "intentions": "Entry socio-cognitive conflict: the students position themselves before any input, which makes the destabilization of moment 3 effective.",
        "notes": "Closed computers. Write down three student formulations on the board, without correcting them, and photograph them.",
        "activities": [
          {
            "description": "Show of hands on three projected statements, then justification by two students from opposing camps. Nothing is validated.",
            "instructions": "Computer closed. For each projected statement, raise your hand: agree / disagree / I don’t know. If I ask you, tell me what makes you think that."
          }
        ]
      },
      {
        "objectives": "Observe that the same question produces different answers.",
        "intentions": "The experiment is carried out by the students themselves: noting the variation has more effect than explaining the mechanism.",
        "activities": [
          {
            "description": "Same question asked three times to [OUTIL IA] by each pair, recording the differences between the three answers obtained.",
            "instructions": "In pairs, ask the exact same question three times in new conversations. Note what changes between the three answers."
          }
        ]
      },
      {
        "objectives": "Check the references produced by the AI ​​one by one.",
        "intentions": "Moment of destabilization: discovering an invented reference yourself is better than hearing it announced.",
        "notes": "Choose a question whose generated answer cites precise and verifiable references.",
        "activities": [
          {
            "description": "Checking each reference cited in a response generated on [SUJET VÉRIFIÉ]: existence, author, actual content.",
            "instructions": "For each source cited by the AI, searches if it really exists: the title, the author, the date. Classify it as “verified”, “not found” or “distorted”."
          }
        ]
      },
      {
        "objectives": "Formalize a reusable verification method.",
        "intentions": "The protocol is produced by the students based on what they have just done: a method given in advance is not applied.",
        "activities": [
          {
            "description": "Writing a personal protocol sheet in four steps, recorded and named correctly.",
            "instructions": "Write your protocol sheet in four steps, in the order in which you will apply them next time. Save it under the requested name."
          }
        ]
      },
      {
        "objectives": "Compare the statements at the start of the session with what was observed.",
        "intentions": "The loop is closed on the formulations noted at moment 1: it is this return which fixes the learning.",
        "activities": [
          {
            "description": "Resumption of the three initial assertions and collective arbitration in the light of the observations made.",
            "instructions": "Consider the three statements from the beginning. For each one, say whether you maintain it and what observation from today you rely on."
          }
        ]
      }
    ]
  },
  "sequence-cinq-seances": {
    "description": "Sequence canvas on [CHAPITRE] in [MATIÈRE], [NIVEAU], in five sessions of 55 min. Each session has a distinct function in progression; the activities must be specified according to the content.",
    "command": "Program for [MATIÈRE], [NIVEAU]: complete sequence on [CHAPITRE].",
    "personas": "1) Distribute the educational functions over five sessions. 2) Guarantee production time and evaluation time.",
    "outcomes": [
      {
        "verb": "Explain",
        "text": "Explain the central concepts of [CHAPITRE]."
      },
      {
        "verb": "Apply",
        "text": "Apply [NOTION 1] in training exercises."
      },
      {
        "verb": "Develop",
        "text": "Develop [PRODUCTION ATTENDUE] mobilizing the entire chapter."
      },
      {
        "verb": "Evaluate",
        "text": "Evaluate your mastery of the skills announced at the start of the sequence."
      }
    ],
    "moments": [
      {
        "objectives": "Open the chapter, collect the representations, ask the leading question.",
        "intentions": "The launch session transmits almost nothing: it establishes the need to know and the contract of the sequence.",
        "notes": "Announce the targeted achievements and the date of the evaluation at this session.",
        "activities": [
          {
            "description": "Hooks from [DOCUMENT DÉCLENCHEUR] and announces the targeted achievements.",
            "instructions": "Note the targeted achievements and the date of the evaluation on the first page of the chapter."
          },
          {
            "description": "Collection of initial representations on [NOTION 1] and formulation of the leading question.",
            "instructions": "Say what you think you know about [NOTION 1], then write the question the chapter needs to answer."
          },
          {
            "description": "First structured contribution on [NOTION 1] and minimal vocabulary of the chapter.",
            "instructions": "Note the definitions in the chapter. To be completed according to the content of your discipline."
          }
        ]
      },
      {
        "objectives": "Install the concepts and reference documents of the chapter.",
        "intentions": "Input session divided into two blocks with intermediate verification, so as not to exceed the useful attention span.",
        "activities": [
          {
            "description": "Support on [NOTION 2], supported on [DOCUMENT 1]. To be specified depending on the content.",
            "instructions": "Take structured notes: definition, example, limit."
          },
          {
            "description": "Work on documents in pairs to apply the concepts provided.",
            "instructions": "In pairs, use the document with the statement table."
          },
          {
            "description": "Written summary summary of the session.",
            "instructions": "Complete the summary of the session without looking at your notes."
          }
        ]
      },
      {
        "objectives": "Practice and differentiate according to the needs observed.",
        "intentions": "Session driven by errors noted in previous sessions: its content cannot be fixed in advance.",
        "activities": [
          {
            "description": "Collective review of the most frequent errors from sessions 1 and 2.",
            "instructions": "Correct the error on the board in your notebook."
          },
          {
            "description": "Differentiated training workshops on [NOTION 1] and [NOTION 2].",
            "instructions": "Choose the workshop that meets your needs. The correction is on the table."
          },
          {
            "description": "Sharing effective methods.",
            "instructions": "Write down a friend's method that you are going to reuse."
          }
        ]
      },
      {
        "objectives": "Mobilize the entire chapter in a production.",
        "intentions": "Production takes place before the evaluation, and not after: it is the last training, in conditions close to the task evaluated.",
        "activities": [
          {
            "description": "Presentation of [PRODUCTION ATTENDUE] and its success criteria.",
            "instructions": "Note the criteria for production success."
          },
          {
            "description": "Realization of [PRODUCTION ATTENDUE] in groups.",
            "instructions": "Produce by checking your progress against the displayed criteria."
          },
          {
            "description": "Cross feedback between groups on productions.",
            "instructions": "Gives another group a highlight and actionable tip."
          }
        ]
      },
      {
        "objectives": "Evaluate the achievements announced at the start of the sequence.",
        "intentions": "The evaluation relates exactly to the acquired knowledge displayed in session 1 and to the formats worked in class.",
        "activities": [
          {
            "description": "Written evaluation on [CHAPITRE], scale announced on the subject.",
            "instructions": "Works alone, without documents. Start with what you know how to do."
          },
          {
            "description": "Self-position yourself on the achievements announced in session 1.",
            "instructions": "Position yourself on each achievement announced at the start of the chapter."
          }
        ]
      }
    ]
  },
  "sortie-pedagogique": {
    "description": "Output at [LIEU DE VISITE] to [MATIÈRE], [NIVEAU]. The visit is framed by a preparation which fixes the work question and by an exploitation which produces a trace.",
    "command": "Program for [MATIÈRE], [NIVEAU]: Study [NOTION 1] in the field at [LIEU DE VISITE].",
    "personas": "1) Make the outing a time of data collection, not contemplation. 2) Produce a trace that can be used in class upon return.",
    "outcomes": [
      {
        "verb": "Identify",
        "text": "Identify in the field the elements related to [NOTION 1]."
      },
      {
        "verb": "Use",
        "text": "Use a survey sheet to collect data on site."
      },
      {
        "verb": "Analyze",
        "text": "Analyze the collected data with regard to [QUESTION DE VISITE]."
      },
      {
        "verb": "Develop",
        "text": "Build [PRODUCTION DE RETOUR] from the statements."
      }
    ],
    "moments": [
      {
        "objectives": "Ask the work question and take ownership of the survey sheet.",
        "intentions": "An outing without prior questions produces memories, not learning: the record sheet is what transforms the visit into an investigation.",
        "notes": "Distribute the statement sheet and check authorizations and materials.",
        "activities": [
          {
            "description": "Introducing [LIEU DE VISITE], [QUESTION DE VISITE] and the hands-on walkthrough of the release.",
            "instructions": "Note the work question of the outing and what you will need to report."
          },
          {
            "description": "Appropriation of the statement sheet through a classroom simulation exercise.",
            "instructions": "In pairs, complete the record sheet based on the projected example, to check that you know what to note."
          }
        ]
      },
      {
        "objectives": "Collect the data necessary to answer the visit question.",
        "intentions": "Time on site is divided between free observation and directed surveys: both are necessary and get in the way if they are not distinguished.",
        "activities": [
          {
            "description": "On-site surveys: observations, photographs, measurements or interviews, according to the prepared sheet.",
            "instructions": "Complete the statement form by group. Photograph what you cannot write down. A photo without a caption will be of no use."
          },
          {
            "description": "Progress report on site: verification that each group has the necessary data.",
            "instructions": "Before leaving, check that your file is complete. It will not be possible to return."
          }
        ]
      },
      {
        "objectives": "Use the readings to answer the visit question.",
        "intentions": "Operation takes place as close as possible to release: beyond a week, the statements become illegible for their authors.",
        "activities": [
          {
            "description": "Pooling and sorting of statements by group, in response to [QUESTION DE VISITE].",
            "instructions": "Sort your statements: what answers the question, what doesn't. Discard what is not useful."
          },
          {
            "description": "Creation of [PRODUCTION DE RETOUR] from the data collected.",
            "instructions": "Carry out your production based on your readings. Each statement must refer to an observation made on site."
          }
        ]
      }
    ]
  },
  "remediation-post-evaluation": {
    "description": "Remediation session after the evaluation of [CHAPITRE] in [MATIÈRE], [NIVEAU]. It exclusively handles the two most frequent errors in the class and verifies that they are raised.",
    "command": "Program of [MATIÈRE], [NIVEAU]: resume [NOTION MAL ACQUISE] after evaluation of [CHAPITRE].",
    "personas": "1) Address two difficulties in depth rather than skimming over everything. 2) Check before the end of the session that the difficulty has been resolved.",
    "outcomes": [
      {
        "verb": "Examine",
        "text": "Examine the origin of its error on [NOTION MAL ACQUISE]."
      },
      {
        "verb": "Execute",
        "text": "Correctly execute the procedure related to [NOTION MAL ACQUISE]."
      },
      {
        "verb": "Distinguish",
        "text": "Distinguish the correct procedure from the confusion that produces the error."
      }
    ],
    "moments": [
      {
        "objectives": "Have students identify the standard error and what produces it.",
        "intentions": "We start from real anonymized copies: the student recognizes his error in that of another, which makes it debatable without exposing anyone.",
        "notes": "Anonymize two copies with standard error. Never name the authors.",
        "activities": [
          {
            "description": "Paired analysis of two anonymous productions carrying the standard error: identification of the exact location and the probable cause.",
            "instructions": "In pairs, find the exact place the copy is wrong, and say what the student probably confused."
          }
        ]
      },
      {
        "objectives": "Reinstall the correct procedure contrasting it with the error.",
        "intentions": "The correct procedure is presented next to the error, not in its place: it is the contrast that prevents the confusion from recurring.",
        "activities": [
          {
            "description": "Two-column presentation of the correct procedure and the incorrect procedure on [NOTION MAL ACQUISE].",
            "instructions": "Note the two columns: on the left what to do, on the right the error to avoid, and what distinguishes them."
          }
        ]
      },
      {
        "objectives": "Repeat the procedure until you carry it out without hesitation.",
        "intentions": "Numerous and short exercises on the single point treated: spaced repetition on a specific point is more effective than a long and composite exercise.",
        "activities": [
          {
            "description": "Series of six short exercises on [NOTION MAL ACQUISE], with autocorrection after each pair.",
            "instructions": "Do the exercises in pairs, and correct yourself after each pair before continuing."
          }
        ]
      },
      {
        "objectives": "Check before the end of the session that the difficulty has been resolved.",
        "intentions": "The exit ticket provides immediate and nominative information: without it, the remediation is never evaluated.",
        "activities": [
          {
            "description": "Exit ticket: a single exercise on the point worked on, noted and corrected by the teacher.",
            "instructions": "Process the exit ticket exercise and return it when leaving. It is not noted, it tells me if it is acquired."
          }
        ]
      }
    ]
  },
  "premiere-seance-annee": {
    "description": "First session of the year in [MATIÈRE], [NIVEAU]. She sets up the working framework, measures the previous year's achievements and puts the class to work from the first day.",
    "command": "[MATIÈRE], [NIVEAU] program: install the working conditions of the year.",
    "personas": "1) Install an explicit and co-constructed working framework. 2) Measure achievements to adjust progress.",
    "outcomes": [
      {
        "verb": "Recall",
        "text": "Recall the class work rules."
      },
      {
        "verb": "Explain",
        "text": "Explain what will be evaluated in [MATIÈRE] this year."
      },
      {
        "verb": "Apply",
        "text": "Apply what you learned from the previous year to a short task."
      }
    ],
    "moments": [
      {
        "objectives": "Present the program, the evaluation methods and the expected material.",
        "intentions": "Framework announced briefly and in writing: what is said orally on the first day is not retained.",
        "notes": "Provide a presentation sheet for the year to stick in the notebook.",
        "activities": [
          {
            "description": "Presentation of the main parts of the year's program, evaluation methods and material.",
            "instructions": "Paste the presentation sheet into your notebook and note the important dates."
          }
        ]
      },
      {
        "objectives": "Establish the work rules and their reasons with the class.",
        "intentions": "The rules are proposed by the students then arbitrated: a rule for which the reason has been stated is better respected than an imposed rule.",
        "activities": [
          {
            "description": "Each group proposes three working rules with their justification; the class selects five, which are then displayed.",
            "instructions": "In fours, suggest three work rules and say what each is for. We will retain five for the year."
          }
        ]
      },
      {
        "objectives": "Measure what is available from previous years.",
        "intentions": "Diagnosis not noted, announced as such: it is used to adjust progression, and its function must be stated to avoid re-entry anxiety.",
        "activities": [
          {
            "description": "Positioning test on [PRÉREQUIS 1] and [PRÉREQUIS 2], not noted, corrected during the following session.",
            "instructions": "Answer alone. This test is not graded: it helps me know where we are starting from."
          }
        ]
      },
      {
        "objectives": "Put the class to work on a short and successful first task.",
        "intentions": "End with a short and successful task: the first session sets the tone for the year, it is better that it ends with effective work.",
        "activities": [
          {
            "description": "First short task on [DOCUMENT 1], chosen to be completed by everyone in ten minutes.",
            "instructions": "In pairs, complete the document task. You must be finished before the end of the hour."
          }
        ]
      }
    ]
  }
}
JSON,
    true,
    512,
    JSON_THROW_ON_ERROR
);
