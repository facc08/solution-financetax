/**
 *
 * You can write your JS code here, DO NOT touch the default style file
 * because it will make it harder for you to update.
 * 
 */

/**
 * aqui añadir cual js que sea modificable 
 * 
 * 
 */

/** codigo para el numero de la tarjeta de credito */
"use strict";

var cleave = new Cleave('.purchase-code', {
    delimiter: '-',
    blocks: [4, 4, 4, 4],
    uppercase: true
  });

function mostrarInfo(id) {
  var row = document.getElementById(id);
  if (row.style.visibility === "collapse") {
      row.style.visibility = "visible";
  } else {
      row.style.visibility = "collapse";
  }
}