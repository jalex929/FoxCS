# RAG Integration Notes: How Retrieval Could Fit Into FoxCS Later

**Added 2026-11-03.** Status: **notes for later, nothing built, not scheduled.** These capture outside review guidance (from a ChatGPT review Jay shared) on how Retrieval-Augmented Generation could be added to FoxCS, mapped onto what already exists in this repo so a future session doesn't have to re-derive it. The public, sanitized version of this plan is `portfolio-showcase/docs/rag-roadmap.md`. This file is the internal one: it names real FoxCS docs, data, and constraints the public version can't.

**The standing position, per the same review:** don't add RAG to impress anyone. Add it only if it solves a specific FoxCS problem, and evaluate it against the current approach before it touches the live grader. A documented negative result (e.g. "skill-ID lookup beats vector search for tightly scoped exercises") is a legitimate outcome.

## 1. What RAG changes, in FoxCS terms

RAG means retrieving relevant content from an approved collection at request time and handing it to the model as context, rather than relying on the model's training or a fixed prompt.

| | Current grading model | RAG-enabled grading model |
|---|---|---|
| Input | Submission + rubric + `05-grader/feedback-and-grading-spec.md` | Submission + assessed skill IDs |
| Context | Fixed per session | Retrieved per submission: relevant lesson excerpts, examples, rubric |
| Output | Skill-aligned feedback | Grounded feedback plus a link to the specific lesson or resource to review |

**FoxCS already does deterministic retrieval.** When a grading session reads the right rubric file for a Coding Exercise (`02-authoring-system/coding-exercise-standards.md` requires one) or a lesson's `mastery_check_KEY.md`, that's retrieval by ID. Embeddings and a vector database only become worth it for finding content by meaning across a larger library. A student writing "my function doesn't give back the value" should still retrieve the return-values lesson.

**The real gap retrieval would close:** `feedback-and-grading-spec.md` Section 13 ("Course Resource Recommendations") already asks feedback to point students to course resources, but nothing hands the reviewer the actual lesson content or a canonical link. Today it has to guess or stay generic.

## 2. Four possible applications

| Option | What it does | FoxCS hook | Priority |
|---|---|---|---|
| **A. Feedback linked to the most relevant lesson** | Reviewer identifies a misconception, retrieves the approved lesson excerpt or practice resource for that skill, cites it | Spec Section 13; per-lesson `NN_instruction.html` files; skills in `courses/python/skills-map.md` | **Start here.** Extends a workflow that already runs, has a clear success criterion, prototypable with synthetic submissions |
| B. Curriculum-grounded student tutor | Answers student questions only from lessons they can access, using course terminology, linking back to assigned material, never exposing assessment content | Instruction pages; `CLAUDE.md`'s "Protecting Assessment Content" rule would have to be enforced in code here, not by prompt | Later. Student-facing, so privacy and permission stakes are highest |
| C. Instructional content assistant | Retrieve objectives, existing examples, and standards before generating new practice items, to stay consistent and avoid duplicates | The 8 canonical `02-authoring-system/` docs; `practice_question_bank.md` files; `objectives-and-skills-proficiency.md` | Useful internally, low risk. A natural fit since authoring is already AI-assisted |
| D. Teacher intervention support | Retrieve approved strategies and activities for skills a class is struggling with, from aggregate skill data only, no student identities | `06-data-and-spreadsheets/` dashboard (not built yet); `local_foxcstelemetry` event data | After the dashboard exists |

## 3. Proposed architecture for option A

Hybrid: deterministic filtering first, semantic search second.

1. **Submission:** assignment ID + assessed skill IDs + the work.
2. **Deterministic retrieval:** filter approved course content by skill, module, publication status (live, not sandbox, per the Pre-Publish Checklist), and student access.
3. **Semantic retrieval:** search lesson excerpts and practice resources by meaning within that filtered set, optionally combined with keyword search.
4. **Context package:** rubric + top excerpts + source references + the feedback spec's constraints.
5. **AI-generated feedback:** misconception + actionable guidance + the relevant lesson link.
6. **Validation and the existing Release Gate:** allowed sources only, format, grading rules, teacher approval (`01-privacy-and-governance/data-boundaries.md`).

**Grade calculation stays separate from retrieval.** Retrieval can change which explanation or resource the feedback points to. An unrelated search result must never change a deterministic grade or override the assignment's rubric.

### Resource record (illustrative schema, not an existing table)

| Field | Example |
|---|---|
| Resource ID | `lesson_functions_return` |
| Skill | Using return values |
| Module | Functions |
| Access level | Published to students |
| Content | Approved lesson excerpt |
| Source link | Canonical Moodle resource reference (cmid-based URL) |
| Embedding | Numeric vector representing meaning |

**Where it could live:** Supabase (Postgres full-text search + pgvector supports hybrid keyword/semantic search, and Jay already knows it). That does not mean moving Moodle or course content into Supabase. Only the small, approved retrieval corpus would live there. Note: this reverses nothing. The 2026-08-18 "prefer spreadsheets over Supabase unless a real need shows up" call in `05-grader/README.md` still holds for grading data. A retrieval index would be a new, separate need.

## 4. Learning it cheaply, in stages

Keep all of this out of the live student workflow until evaluated and approved.

1. **Deterministic retrieval.** A small collection of original or authorized excerpts, fetched by skill ID with plain Python or SQL. Potentially $0 in new AI services. Learn the pipeline before adding embeddings.
2. **Semantic search.** A local embedding model and a small vector index. Compare its results to the skill-ID approach. Potentially $0 in API fees if run locally (it still uses your hardware).
3. **Integrate with feedback generation.** Pass excerpts and source references alongside grading instructions, and require the model to name the resources that actually support its feedback. Cost depends on inference setup. Test with synthetic submissions in small batches.
4. **Evaluate before deployment.** Check that the right resources are retrieved, the feedback reflects them accurately, and the system never exposes restricted answers or invents lesson references.

**Suggested prototype size (a starting point, not a requirement):** 20-40 carefully selected excerpts and 15-25 synthetic questions or submissions with known relevant resources. The eval harness in `portfolio-showcase/evals/` is the natural place to extend for this.

## 5. What to measure

Compare the current feedback process with the RAG-enhanced one.

| Metric | Question |
|---|---|
| Retrieval recall | Was the correct resource in the top results? |
| Retrieval precision | How many returned resources were actually relevant? |
| Groundedness | Is the feedback supported by what was retrieved? |
| Instructional usefulness | Does it help the student take the right next step? |
| Safety and permissions | Does it avoid exposing answer keys or content the student shouldn't access? |
| Cost and latency | Is the improvement worth the added complexity? |

Retrieval quality and generation quality need separate evaluation. A model can retrieve the right lesson and still write poor feedback, or write sensible feedback from the wrong source.

**Example eval cases:** return values (student uses `print()` where a return value is required; expected resource: Functions, return values; expected feedback: names the distinction, explains the consequence, links the approved lesson), loop boundaries, variable scope.

## 6. FoxCS-specific boundaries

- **Student privacy.** Keep real submissions, names, grades, and identifying metadata out of any experimental system. Even with pseudonymous usernames, submission text can contain personal information. Prototype with synthetic submissions only. Any future deployment has to fit district requirements and the still-unconfirmed SOPPA review flagged in `codename-policy.md`.
- **Licensed content cannot go in the corpus.** `licensing-boundaries.md` already bars GMetrix/Certiport material from the commercial `adaptive-python` app. The same reasoning applies here: don't embed GMetrix workbooks, Certiport objectives, or video transcripts unless the license explicitly permits that processing and storage. In practice, the corpus starts with Jay's own authored lesson content only.
- **Assessment content never enters the corpus.** No `mastery_check_KEY.md`, no `teacher-materials/`, no quiz banks. Enforce this at the filter step, in code. A prompt telling the model not to reveal answers is not a security boundary, and this is the same principle as `CLAUDE.md`'s "Protecting Assessment Content" rule.
- **Retrieved documents are untrusted.** They must not be able to override system instructions, grading rules, or permissions. This matters most if student-authored text could ever enter the corpus (e.g. option B or a shared memory-trick bank from the vocab-quiz reflection theme extraction in `05-grader/README.md`).

## 7. What it would exercise, if built

| Skill | Evidence |
|---|---|
| Data modeling | Structured resources, metadata, access rules |
| Retrieval engineering | Keyword, semantic, and hybrid search |
| AI orchestration | Context construction and model integration |
| AI evaluation | Retrieval benchmarks, groundedness tests |
| Quality engineering | Regression tests and deterministic safeguards |
| Product judgment | Measuring whether RAG improves feedback enough to justify its cost |

**Recommendation carried forward:** build a small, separate "FoxCS Retrieval and Feedback Lab" before touching the live grader. Keep the existing grading logic authoritative, add curated instructional retrieval, and compare results against the current feedback approach.

## Prerequisites before any of this starts

1. Resolve the open bonus-points tension in `REPO_MAP.md`'s Known Tensions (Section 15 vs. `grade-point-scale.md`), so the feedback being "improved" has settled scoring rules underneath it.
2. Get baseline eval runs of the current, non-RAG reviewer in `portfolio-showcase/evals/`. RAG can only be shown to help relative to a measured baseline.
3. Confirm a stable skill-ID scheme across lessons (skills exist in `skills-map.md`, but not as machine-readable IDs attached to each lesson file yet).
