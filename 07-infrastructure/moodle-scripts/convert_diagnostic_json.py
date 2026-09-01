import json
import re

with open('diagnostic_full_export.json', 'r', encoding='utf-8') as f:
    data = json.load(f)


def strip_div(html):
    m = re.match(r'^<div>(.*)</div>$', html.strip(), re.DOTALL)
    return m.group(1) if m else html


def php_str(s):
    if s is None:
        s = ''
    s = s.replace('\\', '\\\\').replace("'", "\\'")
    return "'" + s + "'"


lines = []
lines.append('<?php')
lines.append('// AUTO-GENERATED from diagnostic_full_export.json -- do not hand-edit, regenerate instead.')
lines.append('return [')
for q in data['questions']:
    qtext = q['params']['question']
    lines.append('  [')
    lines.append('    "question" => ' + php_str(qtext) + ',')
    lines.append('    "answers" => [')
    for a in q['params']['answers']:
        text = strip_div(a['text'])
        correct = 'true' if a['correct'] else 'false'
        feedback = a.get('tipsAndFeedback', {}).get('chosenFeedback', '')
        feedback = strip_div(feedback) if feedback else ''
        lines.append('      ["text" => ' + php_str(text) + ', "correct" => ' + correct + ', "feedback" => ' + php_str(feedback) + '],')
    lines.append('    ],')
    lines.append('  ],')
lines.append('];')

with open('diagnostic_questions_data.php', 'w', encoding='utf-8') as f:
    f.write('\n'.join(lines))
print('Written', len(data['questions']), 'questions to diagnostic_questions_data.php')
