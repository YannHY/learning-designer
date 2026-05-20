#!/usr/bin/env sh
set -eu

REPO="${LEARNING_DESIGNER_REPO:-YannHY/learning-designer}"
REF="${LEARNING_DESIGNER_REF:-main}"

choose_install_dir() {
  if [ -n "${LEARNING_INSTALL_DIR:-}" ]; then
    printf '%s\n' "$LEARNING_INSTALL_DIR"
    return
  fi

  OLD_IFS=$IFS
  IFS=:
  for dir in $PATH; do
    case "$dir" in
      /usr/local/bin|/opt/homebrew/bin|"$HOME"/.local/bin|"$HOME"/bin)
        if [ -d "$dir" ] && [ -w "$dir" ]; then
          IFS=$OLD_IFS
          printf '%s\n' "$dir"
          return
        fi
        ;;
    esac
  done
  IFS=$OLD_IFS

  case ":$PATH:" in
    *":/usr/local/bin:"*) printf '%s\n' "/usr/local/bin" ;;
    *":/opt/homebrew/bin:"*) printf '%s\n' "/opt/homebrew/bin" ;;
    *) echo "install.sh: no suitable install directory found in PATH" >&2; exit 1 ;;
  esac
}

INSTALL_DIR="$(choose_install_dir)"
TARGET="$INSTALL_DIR/learning"
TMP_FILE="$(mktemp "${TMPDIR:-/tmp}/learning.XXXXXX")"
cleanup() {
  rm -f "$TMP_FILE"
}
trap cleanup EXIT

if [ -f "./bin/learning" ]; then
  cp "./bin/learning" "$TMP_FILE"
else
  URL="https://raw.githubusercontent.com/$REPO/$REF/bin/learning"
  if command -v curl >/dev/null 2>&1; then
    curl -fsSL "$URL" -o "$TMP_FILE"
  elif command -v wget >/dev/null 2>&1; then
    wget -qO "$TMP_FILE" "$URL"
  else
    echo "install.sh: curl or wget is required" >&2
    exit 1
  fi
fi

chmod +x "$TMP_FILE"

if [ ! -d "$INSTALL_DIR" ]; then
  if command -v sudo >/dev/null 2>&1; then
    sudo mkdir -p "$INSTALL_DIR"
  else
    mkdir -p "$INSTALL_DIR"
  fi
fi

if [ -w "$INSTALL_DIR" ]; then
  cp "$TMP_FILE" "$TARGET"
  chmod +x "$TARGET"
elif command -v sudo >/dev/null 2>&1; then
  sudo cp "$TMP_FILE" "$TARGET"
  sudo chmod +x "$TARGET"
else
  echo "install.sh: $INSTALL_DIR is not writable and sudo is unavailable" >&2
  exit 1
fi

echo "Installed learning to $TARGET"
echo "Run: learning --help"
