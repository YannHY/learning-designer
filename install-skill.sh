#!/usr/bin/env sh
set -eu

REPO="${LEARNING_DESIGNER_REPO:-YannHY/learning-designer}"
REF="${LEARNING_DESIGNER_REF:-main}"
SOURCE_DIR="${LEARNING_DESIGNER_SOURCE_DIR:-}"
CLAUDE_SKILL_DIR="${LEARNING_CLAUDE_SKILL_DIR:-$PWD/.claude/skills/learning-design}"
CODEX_SKILL_DIR="${LEARNING_CODEX_SKILL_DIR:-$PWD/.agents/skills/learning-designer}"
TMP_DIR="$(mktemp -d "${TMPDIR:-/tmp}/learning-designer-skill.XXXXXX")"

cleanup() {
  rm -rf "$TMP_DIR"
}
trap cleanup EXIT

download() {
  source_url="$1"
  destination="$2"
  if command -v curl >/dev/null 2>&1; then
    curl -fsSL "$source_url" -o "$destination"
  elif command -v wget >/dev/null 2>&1; then
    wget -qO "$destination" "$source_url"
  else
    echo "Installation impossible : curl ou wget est requis." >&2
    exit 1
  fi
}

SKILL_FILE="$TMP_DIR/SKILL.md"
if [ -n "$SOURCE_DIR" ]; then
  cp "$SOURCE_DIR/skills/learning-designer/SKILL.md" "$SKILL_FILE"
else
  download "https://raw.githubusercontent.com/$REPO/$REF/skills/learning-designer/SKILL.md" "$SKILL_FILE"
fi

if [ -n "$SOURCE_DIR" ]; then
  mkdir -p "$TMP_DIR/bin"
  cp "$SOURCE_DIR/install.sh" "$TMP_DIR/install.sh"
  cp "$SOURCE_DIR/bin/learning" "$TMP_DIR/bin/learning"
else
  download "https://raw.githubusercontent.com/$REPO/$REF/install.sh" "$TMP_DIR/install.sh"
fi

(
  cd "$TMP_DIR"
  LEARNING_DESIGNER_REPO="$REPO" \
    LEARNING_DESIGNER_REF="$REF" \
    LEARNING_INSTALL_NONINTERACTIVE=1 \
    LEARNING_INSTALL_QUIET=1 \
    sh ./install.sh
)

if [ -n "${LEARNING_INSTALL_DIR:-}" ]; then
  LEARNING_BIN="$LEARNING_INSTALL_DIR/learning"
else
  LEARNING_BIN="$(command -v learning || true)"
fi

if [ -z "$LEARNING_BIN" ] || [ ! -x "$LEARNING_BIN" ]; then
  echo "Le CLI Learning Designer a été installé, mais la commande learning reste introuvable dans le PATH." >&2
  exit 1
fi

if ! "$LEARNING_BIN" list school-systems >/dev/null 2>&1 \
  || ! "$LEARNING_BIN" list activity-options >/dev/null 2>&1 \
  || ! "$LEARNING_BIN" init --help 2>&1 | grep -q -- "--school-system" \
  || ! "$LEARNING_BIN" init --help 2>&1 | grep -q -- "--school-level" \
  || ! "$LEARNING_BIN" add-activity --help 2>&1 | grep -q -- "--group" \
  || ! "$LEARNING_BIN" add-activity --help 2>&1 | grep -q -- "--teaching" \
  || ! "$LEARNING_BIN" add-activity --help 2>&1 | grep -q -- "--pacing" \
  || ! "$LEARNING_BIN" add-activity --help 2>&1 | grep -q -- "--mode" \
  || ! "$LEARNING_BIN" add-activity --help 2>&1 | grep -q -- "--evaluation" \
  || ! "$LEARNING_BIN" add-activity --help 2>&1 | grep -q -- "--aias" \
  || ! "$LEARNING_BIN" validate --help 2>&1 | grep -q -- "--strict-pedagogy"; then
  echo "La version installée du CLI n’est pas compatible avec la skill Learning Designer." >&2
  exit 1
fi

mkdir -p "$CLAUDE_SKILL_DIR" "$CODEX_SKILL_DIR"
cp "$SKILL_FILE" "$CLAUDE_SKILL_DIR/SKILL.md"
cp "$SKILL_FILE" "$CODEX_SKILL_DIR/SKILL.md"

printf '\nLearning Designer est installé et prêt.\n'
printf 'Claude Code : %s\n' "$CLAUDE_SKILL_DIR/SKILL.md"
printf 'Codex : %s\n' "$CODEX_SKILL_DIR/SKILL.md"
printf 'CLI : %s\n' "$("$LEARNING_BIN" --version)"
