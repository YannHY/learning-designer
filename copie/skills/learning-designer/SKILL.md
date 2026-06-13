---
name: learning-designer
description: Create, validate, and prepare publication for pedagogical Learning Designer designs using the `learning` CLI. Use when an educator asks to build a lesson, sequence, learning design, instructional scenario, Bloom outcomes, learning moments, digital competencies, or a publishable `design.json` for Learning Designer.
---

# Learning Designer

## Goal

Help an educator create a complete, structured, importable Learning Designer `design.json` with the `learning` CLI, not by hand-editing JSON. Ask the pedagogical questions first, make reasonable assumptions when safe, generate the design with CLI commands, validate it, then explain how to publish it.

## CLI Setup

First check whether `learning` is available:

```bash
learning --help
```

If it is available, use `learning`.

If it is not available or the environment is sandboxed, install a local copy:

```bash
mkdir -p .tools/bin
curl -fsSL https://raw.githubusercontent.com/YannHY/learning-designer/main/bin/learning -o .tools/bin/learning
chmod +x .tools/bin/learning
./.tools/bin/learning --help
```

If `raw.githubusercontent.com` is blocked, use the environment’s web fetch/browser capability to retrieve:

```text
https://github.com/YannHY/learning-designer/blob/main/bin/learning
```

Write the retrieved file to `.tools/bin/learning`, make it executable, and use `./.tools/bin/learning` for all later commands.

Once `.tools/bin/learning` has been created, do not depend on the network again.

Set a variable mentally:

- If global CLI works: `LEARNING=learning`
- If sandbox CLI is used: `LEARNING=./.tools/bin/learning`

## Ask Before Creating

Ask concise questions in French unless the user asks for English. Do not overload the user at the start.

Essential questions:

- subject or theme
- level and target learners
- total duration
- delivery mode: onsite, online, or hybrid
- group size
- teaching objectives: what the teacher wants to work on, transmit, or train
- expected learning outcomes: what learners should be able to do
- constraints: time, tools, assessment, institution, classroom setup
- desired level of detail

Complementary questions to ask only when useful:

- Bloom level for each outcome if known
- digital competencies to mobilize, if relevant
- imposed supports, works, resources, or tools

Distinguish teaching objectives from learning outcomes. If the user gives only teaching objectives, transform them into observable learning outcomes with action verbs and Bloom levels.

If information is missing, make reasonable assumptions instead of blocking, unless the assumption would be risky.

Duration handling:

- If duration is given in days, ask or explicitly propose a per-session duration before generating the full design.
- By default, for middle school/college, interpret `1 day` as `1 session of 55 minutes`, unless the user says otherwise.
- State the assumption clearly.

Before running the complete creation commands, briefly restate:

- subject
- target learners
- total duration converted to minutes
- planned number of moments
- teaching objectives
- proposed Bloom outcomes
- main digital competencies, if any

## Create the Design

Use CLI commands to create and enrich `design.json`. Before creating many activities, inspect the available commands and accepted values:

```bash
$LEARNING --help
$LEARNING init --help
$LEARNING add-moment --help
$LEARNING add-activity --help
$LEARNING outcome --help
$LEARNING list types
$LEARNING list bloom
$LEARNING list competencies
```

Create the file:

```bash
$LEARNING init design.json --title "TITLE" --lang fr --duration 90 --mode onsite --group-size 24 --description "DESCRIPTION" --objectives "TEACHING OBJECTIVES"
```

Add each moment:

```bash
$LEARNING add-moment design.json --title "MOMENT TITLE" --objectives "MOMENT OBJECTIVES" --intentions "PEDAGOGICAL CHOICES"
```

Add each activity:

```bash
$LEARNING add-activity design.json --moment 1 --type investigate --duration 15 --group subgroups --teacher present --pacing sync --mode onsite --evaluation formative --competencies A1,P6 --description "ACTIVITY DESCRIPTION"
```

Use only CLI-controlled values for controlled fields. Safe values:

- `type`: `read`, `investigate`, `practice`, `produce`, `discuss`, `collaborate`
- `group`: `whole`, `subgroups`, `individual`
- `teacher`: `present`, `absent`
- `evaluation`: `none`, `diagnostic`, `formative`, `summative`, `certificative`
- `competencies`: short codes such as `A1`, `P6`, `C14`, comma-separated

For `pacing` and `mode`, verify accepted values with the CLI or use values that the CLI accepts in the current environment. Common accepted values include:

- `pacing`: `sync`, `async`, or `synchronous` depending on CLI version
- `mode`: `onsite`, `online`, `hybrid`, or French aliases such as `presentiel`, depending on CLI version

Never put long natural-language text in controlled fields such as `--group`, `--teacher`, `--evaluation`, `--type`, or `--pacing`.

Put instructions, criteria, supports, teacher role, differentiation details, and pedagogical detail in:

- `--description`
- `--notes`
- `--objectives`
- `--intentions`

Add Bloom outcomes:

```bash
$LEARNING outcome design.json --bloom understand --verb "Expliquer" --text "Expliquer le rôle d’un élément clé du thème étudié."
```

Allowed Bloom levels:

- `remember`
- `understand`
- `apply`
- `analyze`
- `evaluate`
- `create`

Recommended workflow:

1. Create `design.json` with `init`.
2. Add Bloom outcomes with `outcome`.
3. Add one moment and one complete activity to test the accepted CLI values.
4. If the command succeeds, add the remaining moments and activities.
5. If a command fails, explain why, correct the value, and retry.
6. Validate with `validate`.
7. Run `prompt design.json`.

The design should include:

- clearly titled moments
- explicit pedagogical intentions
- varied activities
- realistic durations
- appropriate group modes
- diagnostic, formative, or summative assessment modes where relevant
- Bloom outcomes connected to the activities
- digital competencies where relevant
- descriptions detailed enough for a teacher to use

If the user asks to integrate digital work, propose pedagogically useful uses such as guided research, source checking, collaborative mapping, digital writing, file organization, revision, correction, controlled production, or controlled sharing.

## Validate and Report

Always validate:

```bash
$LEARNING validate design.json
```

If validation fails, fix the design with CLI commands and validate again. Avoid manual JSON edits unless the CLI is genuinely impossible to use.

Generate the handoff prompt when useful:

```bash
$LEARNING prompt design.json
```

At the end, report:

- where `design.json` is
- CLI validation result
- number of moments
- number of activities
- teaching objectives used
- Bloom outcomes created
- digital competencies used
- duration distribution
- assumptions made
- main commands executed

## Publication Guidance

Do not publish from a sandbox unless the user explicitly provides a CLI token and asks you to publish.

For normal use, tell the user to publish from their own Mac/terminal:

```bash
learning validate ~/Desktop/design.json
learning publish ~/Desktop/design.json
```

If the user explicitly gives a token and asks you to publish:

```bash
$LEARNING login
$LEARNING publish design.json
```

Never invent, request publicly, or print a token unless the user deliberately shares it for that session.
