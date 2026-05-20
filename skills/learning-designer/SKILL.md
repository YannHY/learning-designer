---
name: learning-designer
description: Create, validate, and prepare publication for pedagogical Learning Designer designs using the `learning` CLI. Use when an educator asks to build a lesson, sequence, learning design, instructional scenario, Bloom outcomes, learning moments, digital competencies, or a publishable `design.json` for Learning Designer.
---

# Learning Designer

## Goal

Help an educator create a complete Learning Designer `design.json` with the `learning` CLI, not by hand-editing JSON. Ask the pedagogical questions first, generate the design with CLI commands, validate it, then explain how to publish it.

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

Set a variable mentally:

- If global CLI works: `LEARNING=learning`
- If sandbox CLI is used: `LEARNING=./.tools/bin/learning`

## Ask Before Creating

Ask concise questions in French unless the user asks for English:

- subject or theme
- level and target learners
- total duration
- delivery mode: onsite, online, or hybrid
- group size
- teaching objectives: what the teacher wants to work on, transmit, or train
- expected learning outcomes: what learners should be able to do
- Bloom level for each outcome if known
- digital competencies to mobilize, if relevant
- constraints: time, tools, assessment, institution, classroom setup
- desired level of detail

Distinguish teaching objectives from learning outcomes. If the user gives only teaching objectives, transform them into observable learning outcomes with action verbs and Bloom levels.

## Create the Design

Use CLI commands to create and enrich `design.json`.

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
$LEARNING add-activity design.json --moment 1 --type investigate --duration 15 --group subgroups --teacher present --pacing sync --mode onsite --evaluation formative --competencies A6,P34 --description "ACTIVITY DESCRIPTION"
```

Allowed values:

- `type`: `read`, `investigate`, `practice`, `produce`, `discuss`, `collaborate`
- `group`: `whole`, `subgroups`, `individual`
- `teacher`: `present`, `absent`
- `pacing`: `sync`, `async`
- `mode`: `onsite`, `online`, `hybrid`
- `evaluation`: `none`, `diagnostic`, `formative`, `summative`, `certificative`
- `competencies`: short codes such as `A1`, `P6`, `C14`, comma-separated

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
- number of moments
- number of activities
- teaching objectives used
- Bloom outcomes created
- digital competencies used
- duration distribution
- validation result
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
