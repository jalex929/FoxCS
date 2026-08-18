# H5P Authoring: Can This Be Automated?

Direct answer: **yes, largely.** An `.h5p` file is a zip archive containing JSON content data plus references to library code that's already installed on the Moodle server — you don't need to hand-build every activity in the H5P editor UI once you know a content type's schema.

## What's Actually Inside an `.h5p` File

```
my-activity.h5p  (a zip archive)
├── h5p.json           metadata: title, main library + version, preloaded dependencies
└── content/
    └── content.json   the actual content: questions, options, correct answers, feedback text, etc.
```

The library *code* (e.g. `H5P.MultiChoice`, `H5P.DragText`, `H5P.CoursePresentation`) is not bundled in your package — it's already installed on the Moodle instance (via the H5P Hub in Site Administration). Your package just references it by name and version in `h5p.json`. Moodle's H5P plugin (native since Moodle 3.9 — your local instance is 5.3dev, well past that) handles everything else.

## The Practical Workflow for Speed + Automation

1. **Hand-author one good example of each content type you'll reuse** — MultiChoice, DragText/drag-drop, Course Presentation, Question Set, Flashcards, whatever the lesson templates need — through Moodle's H5P editor, once each.
2. **Export each as `.h5p`, unzip it.** The `content.json` and `h5p.json` inside are now your working templates/schema reference. Save these in the repo (suggest `02-authoring-system/h5p-templates/`) rather than re-deriving them from H5P's public documentation each time — an exported real example is more reliable than reading semantics docs cold.
3. **Write a small generator** (Node or Python — either is fine, whichever you're faster in) that takes a lesson record's `moodle.h5p_activities` block (per `lesson-schema.md`) and populates the template JSON programmatically, then zips the result into a valid `.h5p` file.
4. **Upload the generated `.h5p` files** — either through the H5P activity's "Upload" option in Moodle (fast even done manually, since the content itself is already fully authored) or via Web Services, if the write functions you need are actually exposed on this instance (see below).

This is exactly the kind of automation-friendly path you're looking for: content generated elsewhere (by the authoring pipeline, from the canonical lesson record) becomes a real H5P package without touching the H5P editor UI per-item.

## Web Services Automation — Needs Verification Against This Instance

Whether the *upload and activity creation* step can also be scripted (not just the content generation) depends on which Web Services functions are actually enabled on your local install. This wasn't verifiable without the running instance — now that Moodle is installed locally (`C:\Users\Jay Fox\server\moodle`, `Start Moodle.exe`), check Site Administration → Server → Web Services → API documentation for `mod_h5pactivity`-related functions once it's running. If the write functions are there, file upload happens through the draft-file-area mechanism (`core_files_upload` or the file-picker draft area) followed by a `mod_h5pactivity` create call referencing that draft file.

**One caution:** your local build is `5.3dev` — a development branch, not a stable release. Web Services function availability and behavior can be less predictable on a dev branch than on a numbered stable release. Worth confirming this is intentional (testing against bleeding-edge before a stable release ships) rather than an accidental download of the wrong build.

## Bottom Line

- Content authoring: automate fully, per the workflow above.
- Upload/activity creation: manual-but-fast (drag a folder of generated `.h5p` files into Moodle) is a safe fallback that's still much faster than the editor UI, if Web Services automation doesn't pan out on this instance.
