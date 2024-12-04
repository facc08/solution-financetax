"use strict";

var cleave = new Cleave('.purchase-code', {
  delimiter: '-',
  blocks: [4, 4, 4, 4],
  uppercase: true
});
