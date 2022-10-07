new TomSelect("#addProf", {
	create: true,
	sortField: {
		field: "text",
		direction: "asc"
	},
    render: {
        option_create: function(data, escape) {
			return '<div class="create">Adicionar <strong>' + escape(data.input) + '</strong>&hellip;</div>';
		},
        no_results:function(data,escape){
			return '<div class="no-results">Nenhum resultado encontrado para "'+escape(data.input)+'"</div>';
		}
    }
});

function loading() {

}

function getEspecs() {
	
}