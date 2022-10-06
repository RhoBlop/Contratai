var search_terms = ['designer gráfico', 'pintor de acabamento', 'professor de física', 'professor de história'];

function autocompleteMatch(input) {
  if (input == '') {
    return [];
  }
  var reg = new RegExp(input)
  return search_terms.filter(function(term) {
	  if (term.match(reg)) {
  	  return term;
	  }
  });
}

function showResults(val) {
  res = document.getElementById("resultado");
  res.innerHTML = '';
  let list = '';
  let terms = autocompleteMatch(val);
  for (i=0; i<terms.length; i++) {
    list += '<li class="list-group-item">' + terms[i] + '</li>';
  }
  res.innerHTML = '<ul class="list-group">' + list + '</ul>';
}