<?php
// AUTO-GENERATED from diagnostic_full_export.json -- do not hand-edit, regenerate instead.
return [
  [
    "question" => '<p>Evaluate: 9 &minus; 2 &times; 3 + 4</p>',
    "answers" => [
      ["text" => '3', "correct" => false, "feedback" => 'This drops the final + 4 step. Try: after finding 9 &minus; 6, add the 4.'],
      ["text" => '25', "correct" => false, "feedback" => 'This solves left to right instead of doing the multiplication first. Try: 2 &times; 3 first.'],
      ["text" => '7', "correct" => true, "feedback" => '2 &times; 3 = 6, then 9 &minus; 6 + 4 = 7.'],
      ["text" => '&minus;5', "correct" => false, "feedback" => 'This adds 3 and 4 before multiplying, which changes the problem. Try: only 2 &times; 3 gets grouped.'],
    ],
  ],
  [
    "question" => '<p>Evaluate: &minus;8 + 5 &minus; (&minus;3)</p>',
    "answers" => [
      ["text" => '&minus;6', "correct" => false, "feedback" => 'Subtracting a negative 3 should become adding 3. Try: rewrite &minus;(&minus;3) as +3.'],
      ["text" => '0', "correct" => true, "feedback" => '&minus;8 + 5 + 3 = 0.'],
      ["text" => '&minus;16', "correct" => false, "feedback" => 'This treats every number as negative. Try: only the middle term is positive (+5).'],
      ["text" => '10', "correct" => false, "feedback" => 'This drops the negative sign on the first number. Try: start at &minus;8, not 8.'],
    ],
  ],
  [
    "question" => '<p>A submarine is at 120 feet below sea level. It rises 45 feet, then descends 60 feet. What is its new depth?</p>',
    "answers" => [
      ["text" => '75 feet below sea level', "correct" => false, "feedback" => 'This stops after the rise and skips the descent. Try: apply both moves in order.'],
      ["text" => '135 feet below sea level', "correct" => true, "feedback" => '&minus;120 + 45 &minus; 60 = &minus;135, so 135 feet below sea level.'],
      ["text" => '225 feet below sea level', "correct" => false, "feedback" => 'This treats the 45-foot rise as a drop instead of an increase. Try: rising means adding, not subtracting.'],
      ["text" => '105 feet above sea level', "correct" => false, "feedback" => 'This mixes up the direction of the starting depth. Try: 120 feet below sea level starts as &minus;120.'],
    ],
  ],
  [
    "question" => '<p>A reaction produces between 2.8 and 3.4 grams of product per trial, run over 12 trials. Which is the best estimate of the total grams produced?</p>',
    "answers" => [
      ["text" => 'about 34 g', "correct" => false, "feedback" => 'This only uses the lowest possible amount per trial. Try: use a reasonable middle value, like 3 g.'],
      ["text" => 'about 36 g', "correct" => true, "feedback" => 'Rounding to about 3 g per trial: 3 &times; 12 = 36 g.'],
      ["text" => 'about 41 g', "correct" => false, "feedback" => 'This only uses the highest possible amount per trial. Try: a middle estimate is more reasonable than the maximum.'],
      ["text" => 'about 7 g', "correct" => false, "feedback" => 'This estimates the range itself instead of the total. Try: multiply grams-per-trial by the number of trials.'],
    ],
  ],
  [
    "question" => '<p>Write 3/8 as a decimal.</p>',
    "answers" => [
      ["text" => '0.35', "correct" => false, "feedback" => 'Check the division again: 3 &divide; 8, not a rounded guess.'],
      ["text" => '0.375', "correct" => true, "feedback" => '3 &divide; 8 = 0.375.'],
      ["text" => '0.38', "correct" => false, "feedback" => 'Close, but this rounds too early. Try: 3 &divide; 8 all the way out.'],
      ["text" => '2.67', "correct" => false, "feedback" => 'This divides 8 by 3 instead of 3 by 8. Try: numerator &divide; denominator, in that order.'],
    ],
  ],
  [
    "question" => '<p>Compute: 2/3 + 1/4</p>',
    "answers" => [
      ["text" => '3/7', "correct" => false, "feedback" => 'This adds numerators and denominators separately. Try: find a common denominator first.'],
      ["text" => '11/12', "correct" => true, "feedback" => '2/3 = 8/12 and 1/4 = 3/12, so 8/12 + 3/12 = 11/12.'],
      ["text" => '11/7', "correct" => false, "feedback" => 'The numerator is right, but the denominator wasn\'t converted to a common denominator. Try: both fractions need the same bottom number.'],
      ["text" => '3/4', "correct" => false, "feedback" => 'Check the common denominator step again &mdash; 3/12 shouldn\'t simplify away like that.'],
    ],
  ],
  [
    "question" => '<p>Compute: 3/5 &divide; 2/3</p>',
    "answers" => [
      ["text" => '2/5', "correct" => false, "feedback" => 'This multiplies the fractions as given. Try: flip the second fraction first, then multiply.'],
      ["text" => '9/10', "correct" => true, "feedback" => '3/5 &divide; 2/3 = 3/5 &times; 3/2 = 9/10.'],
      ["text" => '10/9', "correct" => false, "feedback" => 'This flips the first fraction instead of the second. Try: keep the first fraction as is, flip the one after the &divide; sign.'],
      ["text" => '3/10', "correct" => false, "feedback" => 'Check which numbers get multiplied together after flipping the second fraction.'],
    ],
  ],
  [
    "question" => '<p>A recipe needs 2&frac14; cups of flour for one batch. A baker wants to make 1/3 of a batch. How many cups of flour are needed?</p>',
    "answers" => [
      ["text" => '3/4 cup', "correct" => true, "feedback" => '2&frac14; = 9/4. 9/4 &times; 1/3 = 9/12 = 3/4 cup.'],
      ["text" => '2/3 cup', "correct" => false, "feedback" => 'This only scales the whole-number part of 2&frac14;. Try: convert the full mixed number to a fraction first.'],
      ["text" => '6&frac34; cups', "correct" => false, "feedback" => 'This divides by 1/3 instead of multiplying. Try: making a smaller portion means multiplying by a fraction less than 1.'],
      ["text" => '2 7/12 cups', "correct" => false, "feedback" => 'This adds the fractions instead of multiplying. Try: a portion of a recipe is found by multiplying.'],
    ],
  ],
  [
    "question" => '<p>What is 30% of 150?</p>',
    "answers" => [
      ["text" => '15', "correct" => false, "feedback" => 'This finds 10% of 150 and stops. Try: 30% is three times that.'],
      ["text" => '45', "correct" => true, "feedback" => '0.30 &times; 150 = 45.'],
      ["text" => '120', "correct" => false, "feedback" => 'This subtracts 30 from 150 instead of finding 30% of 150.'],
      ["text" => '4.5', "correct" => false, "feedback" => 'The decimal point is in the wrong place. Try: 30% = 0.30, not 0.03.'],
    ],
  ],
  [
    "question" => '<p>A shirt\'s price increased from $40 to $46. What was the percent increase?</p>',
    "answers" => [
      ["text" => '6%', "correct" => false, "feedback" => 'This treats the $6 change itself as the percent. Try: divide the change by the original price.'],
      ["text" => '13%', "correct" => false, "feedback" => 'This divides the change by the new price ($46) instead of the original price. Try: percent increase compares to where you started.'],
      ["text" => '15%', "correct" => true, "feedback" => 'Change = $6. 6 &divide; 40 = 0.15 = 15%.'],
      ["text" => '115%', "correct" => false, "feedback" => 'This finds the new price as a percent of the old price but forgets to subtract the original 100%.'],
    ],
  ],
  [
    "question" => '<p>A jacket costs $60. It is discounted 20%, and then a 5% sales tax is applied to the discounted price. What is the final price?</p>',
    "answers" => [
      ["text" => '$48.00', "correct" => false, "feedback" => 'This applies the discount correctly but forgets the tax step. Try: apply 5% tax to the new $48 price.'],
      ["text" => '$48.60', "correct" => false, "feedback" => 'This applies the tax to the discount amount instead of the discounted price.'],
      ["text" => '$50.40', "correct" => true, "feedback" => '$60 &times; 0.80 = $48. $48 &times; 1.05 = $50.40.'],
      ["text" => '$51.00', "correct" => false, "feedback" => 'This combines 20% off and 5% tax into a single 15%-off calculation. Try: apply each percent as its own step.'],
    ],
  ],
  [
    "question" => '<p>A car travels 240 miles in 4 hours. What is its rate in miles per hour?</p>',
    "answers" => [
      ["text" => '40 mph', "correct" => false, "feedback" => 'Check the division again: 240 &divide; 4.'],
      ["text" => '60 mph', "correct" => true, "feedback" => '240 &divide; 4 = 60 miles per hour.'],
      ["text" => '244 mph', "correct" => false, "feedback" => 'This adds instead of dividing. Try: rate is distance &divide; time.'],
      ["text" => '960 mph', "correct" => false, "feedback" => 'This multiplies instead of dividing. Try: rate is distance &divide; time.'],
    ],
  ],
  [
    "question" => '<p>Solve for x: 3/8 = x/40</p>',
    "answers" => [
      ["text" => '13.3', "correct" => false, "feedback" => 'This solves 40/3 instead of setting up the cross-product correctly.'],
      ["text" => '15', "correct" => true, "feedback" => 'Cross multiply: 8x = 3 &times; 40 = 120, so x = 15.'],
      ["text" => '106.7', "correct" => false, "feedback" => 'The cross-multiplication paired the wrong numbers. Try: multiply straight across the equals sign (3 &times; 40 and 8 &times; x).'],
      ["text" => '32', "correct" => false, "feedback" => 'This subtracts instead of solving the proportion. Try: cross multiply first.'],
    ],
  ],
  [
    "question" => '<p>A recipe uses a ratio of 2 cups of rice to 3 cups of water. A cook wants to make a large batch using 9 cups of water. How many cups of rice are needed?</p>',
    "answers" => [
      ["text" => '4.5 cups', "correct" => false, "feedback" => 'This just halves 9 instead of using the 2:3 ratio. Try: set up 2/3 = x/9.'],
      ["text" => '6 cups', "correct" => true, "feedback" => '2/3 = x/9. Cross multiply: 3x = 18, so x = 6.'],
      ["text" => '11 cups', "correct" => false, "feedback" => 'This adds instead of scaling the ratio. Try: use a proportion, not addition.'],
      ["text" => '13.5 cups', "correct" => false, "feedback" => 'This uses the ratio flipped (water to rice instead of rice to water).'],
    ],
  ],
  [
    "question" => '<p>Evaluate 4x &minus; 7 when x = 5.</p>',
    "answers" => [
      ["text" => '&minus;8', "correct" => false, "feedback" => 'This computes 4(5 &minus; 7) instead of (4 &times; 5) &minus; 7. Try: multiply first, then subtract.'],
      ["text" => '2', "correct" => false, "feedback" => 'This adds 4 and 5 instead of multiplying. Try: 4x means 4 &times; x.'],
      ["text" => '13', "correct" => true, "feedback" => '4(5) = 20, then 20 &minus; 7 = 13.'],
      ["text" => '27', "correct" => false, "feedback" => 'The sign on 7 flipped. Try: the expression subtracts 7, it doesn\'t add it.'],
    ],
  ],
  [
    "question" => '<p>Simplify: 5x + 3 &minus; 2x + 8</p>',
    "answers" => [
      ["text" => '3x + 11', "correct" => true, "feedback" => '5x &minus; 2x = 3x. 3 + 8 = 11.'],
      ["text" => '7x + 11', "correct" => false, "feedback" => 'This adds the x-coefficients instead of subtracting. Try: 5x &minus; 2x, not 5x + 2x.'],
      ["text" => '3x &minus; 5', "correct" => false, "feedback" => 'The sign on the constants flipped. Try: 3 + 8, not 3 &minus; 8.'],
      ["text" => '3x + 5', "correct" => false, "feedback" => 'Check the constant terms again: 3 and 8 should be added, not subtracted.'],
    ],
  ],
  [
    "question" => '<p>Write an expression for &quot;7 less than three times a number n.&quot;</p>',
    "answers" => [
      ["text" => '3n &minus; 7', "correct" => true, "feedback" => '&quot;7 less than&quot; means subtract 7 from three times n.'],
      ["text" => '7 &minus; 3n', "correct" => false, "feedback" => '&quot;7 less than X&quot; means X &minus; 7, not 7 &minus; X. Try: rewrite as &quot;three times n, minus 7.&quot;'],
      ["text" => '3(n &minus; 7)', "correct" => false, "feedback" => 'This groups the subtraction with n itself. Try: only 7 is being subtracted, not 7 from n first.'],
      ["text" => '3n + 7', "correct" => false, "feedback" => '&quot;Less than&quot; means subtraction, not addition.'],
    ],
  ],
  [
    "question" => '<p>Solve for x: 2x + 5 = 17</p>',
    "answers" => [
      ["text" => '6', "correct" => true, "feedback" => '2x = 12, so x = 6.'],
      ["text" => '8.5', "correct" => false, "feedback" => 'This divides by 2 before subtracting the 5. Try: subtract 5 first, then divide.'],
      ["text" => '11', "correct" => false, "feedback" => 'This adds 5 instead of subtracting it. Try: undo the +5 by subtracting.'],
      ["text" => '24', "correct" => false, "feedback" => 'This multiplies instead of dividing at the last step.'],
    ],
  ],
  [
    "question" => '<p>Solve for x: 3(x &minus; 4) = 18</p>',
    "answers" => [
      ["text" => '2', "correct" => false, "feedback" => 'The sign flipped during distribution. Try: 3 times &minus;4 is &minus;12, not +12.'],
      ["text" => '7.3', "correct" => false, "feedback" => 'This only distributes to the x, not the 4. Try: 3(x &minus; 4) = 3x &minus; 12.'],
      ["text" => '10', "correct" => true, "feedback" => '3x &minus; 12 = 18, so 3x = 30, and x = 10.'],
      ["text" => '30', "correct" => false, "feedback" => 'This finds 3x but forgets the final division by 3.'],
    ],
  ],
  [
    "question" => '<p>A rectangle\'s length is 3 more than twice its width. If the perimeter is 36, what is the width?</p>',
    "answers" => [
      ["text" => '5', "correct" => true, "feedback" => 'Let w = width, length = 2w + 3. Perimeter: 2(2w + 3 + w) = 6w + 6 = 36, so w = 5.'],
      ["text" => '6', "correct" => false, "feedback" => 'This ignores the &quot;+3&quot; in the length. Try: length = 2w + 3, not just 2w.'],
      ["text" => '11', "correct" => false, "feedback" => 'This sets up length + width = 36 instead of doubling for perimeter.'],
      ["text" => '13', "correct" => false, "feedback" => 'This finds the length, not the width the question asked for.'],
    ],
  ],
  [
    "question" => '<p>A phone plan costs $25 per month plus $0.10 per text message sent. If a customer\'s bill was $37, how many text messages did they send?</p>',
    "answers" => [
      ["text" => '12', "correct" => false, "feedback" => 'This is the dollar amount above the base fee, not the number of texts. Try: divide that amount by $0.10.'],
      ["text" => '120', "correct" => true, "feedback" => '$37 &minus; $25 = $12. $12 &divide; $0.10 = 120 texts.'],
      ["text" => '250', "correct" => false, "feedback" => 'This divides the base fee by the rate instead of the amount above it.'],
      ["text" => '370', "correct" => false, "feedback" => 'This divides the whole bill by the rate without subtracting the $25 base fee first.'],
    ],
  ],
  [
    "question" => '<p>A store buys a lamp for $40 and sells it for $54. What is the markup as a percent of the cost?</p>',
    "answers" => [
      ["text" => '14%', "correct" => false, "feedback" => 'This treats the $14 difference itself as the percent. Try: divide the change by the original cost.'],
      ["text" => '26%', "correct" => false, "feedback" => 'This divides by the selling price ($54) instead of the cost ($40).'],
      ["text" => '35%', "correct" => true, "feedback" => 'Increase = $14. 14 &divide; 40 = 0.35 = 35%.'],
      ["text" => '135%', "correct" => false, "feedback" => 'This finds the selling price as a percent of the cost but forgets to subtract the original 100%.'],
    ],
  ],
  [
    "question" => '<p>A store\'s sales tripled from Monday to Tuesday, then dropped by half from Tuesday to Wednesday. If Wednesday\'s sales were $90, what were Monday\'s sales?</p>',
    "answers" => [
      ["text" => '$30', "correct" => false, "feedback" => 'This only undoes the tripling step. Try: first undo the drop-by-half to find Tuesday, then undo the tripling.'],
      ["text" => '$60', "correct" => true, "feedback" => 'Wednesday = Tuesday &divide; 2, so Tuesday = $180. Tuesday = 3 &times; Monday, so Monday = $60.'],
      ["text" => '$180', "correct" => false, "feedback" => 'This finds Tuesday\'s sales but stops before undoing the tripling to reach Monday.'],
      ["text" => '$270', "correct" => false, "feedback" => 'This triples Wednesday\'s sales directly, skipping the halving step entirely.'],
    ],
  ],
  [
    "question" => '<p>A student estimates 19 &times; 21 by rounding both numbers to the nearest ten. What is the estimate?</p>',
    "answers" => [
      ["text" => '200', "correct" => false, "feedback" => 'Check the rounding: 19 rounds to 20, not 10.'],
      ["text" => '399', "correct" => false, "feedback" => 'This is the exact product, not the rounded estimate the question asked for.'],
      ["text" => '400', "correct" => true, "feedback" => '19 rounds to 20 and 21 rounds to 20. 20 &times; 20 = 400.'],
      ["text" => '1,600', "correct" => false, "feedback" => 'This rounds to the nearest hundred instead of the nearest ten.'],
    ],
  ],
];