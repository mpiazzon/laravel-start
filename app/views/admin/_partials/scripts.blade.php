<script>
  

  //var primaryColor = '#7789D1', azul
  var primaryColor = '#eb6a5a',
    dangerColor = '#b55151',
    successColor = '#609450',
    warningColor = '#ab7a4b',
    inverseColor = '#45484d';
  
  var themerPrimaryColor = primaryColor;
  </script>
  
<script src="{{ URL::asset('admin/js/bootstrap.min.js') }}"></script>
<script src="{{ URL::asset('admin/js/jasny-bootstrap.min.js') }}"></script>
<script src="{{ URL::asset('admin/js/holder.js') }}"></script>
<script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/jquery-ui.min.js"></script>
<script src="{{ URL::asset('admin/js/jquery.nicescroll.min.js') }}"></script>
<script src="{{ URL::asset('admin/js/image-preview.js') }}"></script>
<script src="{{ URL::asset('admin/js/animations.init.js') }}"></script>
<script src="{{ URL::asset('admin/js/jquery.cookie.js') }}"></script>
<script src="{{ URL::asset('admin/js/dropzone.js') }}"></script>
<script src="{{ URL::asset('admin/js/toastr.js') }}"></script>


<script src="http://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>

<script src="{{ URL::asset('admin/tinymce/tinymce.dev.js') }}"></script>
<script src="{{ URL::asset('admin/tinymce/plugins/table/plugin.dev.js') }}"></script>
<script src="{{ URL::asset('admin/tinymce/plugins/paste/plugin.dev.js') }}"></script>
<script src="{{ URL::asset('admin/tinymce/plugins/spellchecker/plugin.dev.js') }}"></script>


<script src="{{ URL::asset('admin/js/core.init.js') }}"></script>

<script type="text/javascript">
$(document).ready(function () {
	
	var public_path = "{{url()}}";
	toastr.options = {
	  "closeButton": false,
	  "debug": false,
	  "positionClass": "toast-bottom-right",
	  "onclick": null,
	  "showDuration": "599",
	  "hideDuration": "1000",
	  "timeOut": "5000",
	  "extendedTimeOut": "1000",
	  "showEasing": "swing",
	  "hideEasing": "linear",
	  "showMethod": "fadeIn",
	  "hideMethod": "fadeOut"
	};

	$(".dz-file-preview").click(function(){
		cargaEscudo($(this).data('id'),public_path,this);
	});

	$(".dz-file-preview22").click(function(){
		cargaImagen($(this).data('id'),public_path,this);
	});

	Dropzone.autoDiscover = false;

	if( $('div#drop_equipos').length ) { 
	var escudos_up = new Dropzone("div#drop_equipos", 
		{ url: "{{ URL::route('admin.subirEquipos') }}",
		  previewTemplate: "<div data-id=\"\" class=\"dz-preview dz-file-preview\" >\n     <div class=\"dz-details\">\n <img data-dz-thumbnail />\n  <input type=\"hidden\" id=\"escudo-nombre\" value=\"\"></div>\n  <div class=\"dz-progress\"><span class=\"dz-upload\" data-dz-uploadprogress></span></div>\n  <div class=\"dz-success-mark\"><span>✔</span></div>\n  <div class=\"dz-error-mark\"><span>✘</span></div>\n  <div class=\"dz-error-message\"><span data-dz-errormessage></span></div>\n</div>"	
		,
		   init: function() {
					this.on("success", function(file, response) {
	      		file.serverId = response;
	      		$(file.previewElement).data("id",file.serverId); 
    			});
		    }
		}
	);

	escudos_up.on("complete", function(file) {
	  setTimeout(function() {
	  	var url = JSON.parse(file.xhr.response);
	  	$(file.previewElement).data("id",url);
	  	
	  	$(file.previewElement).find(".dz-success-mark").hide();
	  	cargaEscudo(file.serverId,public_path,$(file.previewElement));
	  }, 3000 );

	  file.previewElement.addEventListener("click", function() {
	  	cargaEscudo(file.serverId,public_path,$(file.previewElement));
	  });

	});
	}
    
    function cargaEscudo(id, public_path,ob) {
    	$("#info-imagen").show();
    	$.getJSON( "{{ URL::to('cpanel/equipos/json') }}/"+id, function( data ) {
			var infoimagen = $("#info-imagen");
			infoimagen.find("img").attr("src",public_path + "/uploads/escudos/" +data.ruta);
			infoimagen.find(".archivo").html(data.ruta);
			infoimagen.find("input[name='nombre']").val(data.nombre);
			infoimagen.find("input[name='nombre_corto']").val(data.nombre_corto);
			infoimagen.find("textarea[name='descripcion']").val(data.descripcion);
			infoimagen.find("input[name='imagen_id']").val(data.id);
		});
    }

    
    $("#info-imagen .autoact").change(function(){
    	var infoimagen = $("#info-imagen");
    	campo = $(this).attr("name");
    	valor = $(this).attr("value");
    	id = infoimagen.find("input[name='imagen_id']").val();
    	$.post( "{{ URL::to('cpanel/equipos/ajax/update') }}/"+id, { campo: campo, valor: valor }) 

    		.done(function( data ) {
				$("#guardado").fadeIn();
			});
    });

    $("#info-imagen .borrar").on( "click", function(event) {
    	event.preventDefault();
    	id = $("#info-imagen").find("input[name='imagen_id']").val();
    	
    		
    	$.post( "{{ URL::to('cpanel/equipos/ajax/delete') }}/"+id) 

    		
    		.done(function( data ) {
    			id = $("#info-imagen input[name='imagen_id']").val();
    			
    			//$("#drop_equipos").find("[data-id='" + id + "']").remove();
    			window.location.reload();
				
				//$("#info-imagen").hide();
				//$("#info-imagen img").attr("src","");

				//toastr.warning('La imagen se elimino correctamente.');
			});
			
		
    	return false;
    });


    $(".draggable").draggable({
		helper: 'clone',
		appendTo: 'body',
		});
		$(".dropped").droppable({
		accept: ".draggable",
		activeClass: 'droppable-active',
		hoverClass: 'droppable-hover',

		drop: function(ev, ui) {

			$(this).html($(ui.draggable).clone());
			id_escudo = $(ui.draggable).clone().data('id');
			
			if ($(this).hasClass('local'))
					$("#equipo-local-escudo").val(id_escudo);
			if ($(this).hasClass('visitante'))
					$("#equipo-visitante-escudo").val(id_escudo);
						
		},

		tolerance: 'fit'
	});

	$( "#datepicker" ).datepicker();

	$(".carga-torneo").click(function(event){
		event.preventDefault();
		if ($("#nombre-torneo").val() == '' ) {
			$("#nombre-torneo").addClass('border-red');
			return false;
		}
		$.post(  "{{ URL::to('cpanel/torneo/agregar') }}" , { nombre: $("#nombre-torneo").val(), tipo: $("#tipo-torneo").val() }) 

    		.done(function( data ) {
				$("#nombre-torneo").removeClass('border-red');
				$("#nombre-torneo").val('');
				$('#agregar-torneo').modal('toggle')
				toastr.warning('El torneo se agrego correctamente.');
			});
		return false;
	});

	$(".carga-evento").click(function(event){
		event.preventDefault();
		if ($("#nombre-evento").val() == '' ) {
			$("#nombre-evento").addClass('border-red');
			return false;
		}
		$.post(  "{{ URL::to('cpanel/evento/agregar') }}" , { nombre: $("#nombre-evento").val() }) 

    		.done(function( data ) {
				$("#nombre-evento").removeClass('border-red');
				$("#nombre-evento").val('');
				$('#agregar-evento').modal('toggle')
				toastr.warning('El evento se agrego correctamente.');
			});
		return false;
	});

	$(".actu-torneo").click(function(){
		id = $(this).data('t-id');
		nombre = '#t-nombre-' + id;
		tipo = '#t-tipo-' + id;
		$.post(  "{{ URL::to('cpanel/torneo/actualizar') }}" , { nombre: $(nombre).val(), tipo: $(tipo).val(), id: id }) 

    		.done(function( data ) {
					toastr.warning('El torneo se actualizo correctamente.');
			});
		return false;
	});

	$(".eli-torneo").click(function(){
		id = $(this).data('t-id');
		$(this).closest('.list-group-item').remove();
		console.log($(this).closest('.list-group-item').html());
		
		$.post(  "{{ URL::to('cpanel/torneo/eliminar') }}" , { id: id }) 
    		.done(function( data , t) {
					toastr.warning('El torneo se elimino correctamente.');
					
			});
		return false;
	});

	$(".actu-evento").click(function(){
		id = $(this).data('t-id');
		nombre = '#t-nombre-' + id;
		$.post(  "{{ URL::to('cpanel/evento/actualizar') }}" , { nombre: $(nombre).val(), id: id }) 

    		.done(function( data ) {
					toastr.warning('El evento se actualizo correctamente.');
			});
		return false;
	});

	$(".eli-evento").click(function(){
		id = $(this).data('t-id');
		$(this).closest('.list-group-item').remove();
		console.log($(this).closest('.list-group-item').html());
		
		$.post(  "{{ URL::to('cpanel/evento/eliminar') }}" , { id: id }) 
    		.done(function( data , t) {
					toastr.warning('El evento se elimino correctamente.');
					
			});
		return false;
	});

	$("#noticia-tipo").change(function(){
		if ($('select[name="noticia-tipo"]').val() == 'local') {
			$("#noticia-torneo-local").show();
			$("#noticia-torneo-inter").hide();
			// cargar torneos locales
		}

		if ($('select[name="noticia-tipo"]').val() == 'internacional') {
			$("#noticia-torneo-inter").show();
			$("#noticia-torneo-local").hide();
			// cargar torneos internacionales
		}

	});

	$("#noticia-torneo-local").change(function(){
		$("#noticia-torneo-fecha").show();
		torneo_id = $('select[name="noticia-torneo-local"]').val();

		console.log(torneo_id);
		$("#noticia-torneo-fecha").load("{{ URL::route('admin.buscaFechas') }}", {'torneo_id': torneo_id}); 

	});

	$("#noticia-torneo-inter").change(function(){
		$("#noticia-torneo-fecha").show();
		torneo_id = $('select[name="noticia-torneo-inter"]').val();
		console.log(torneo_id);
		$("#noticia-torneo-fecha").load("{{ URL::route('admin.buscaFechas') }}", {'torneo_id': torneo_id}) 
	});


tinymce.init({
		selector: "textarea#noticia-desc",
		theme: "modern",
		language : 'es',

		plugins: [
			"advlist autolink link image lists charmap print preview hr anchor pagebreak spellchecker",
			"searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime media nonbreaking",
			"save table contextmenu directionality emoticons template paste textcolor importcss"
		],
		external_plugins: {
			//"moxiemanager": "/moxiemanager-php/plugin.js"
		},
		content_css: "css/development.css",
		add_unload_trigger: false,

		toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link | preview fullpage | forecolor backcolor emoticons table",

		image_advtab: true,

		style_formats: [
			{title: 'Bold text', format: 'h1'},
			{title: 'Red text', inline: 'span', styles: {color: '#ff0000'}},
			{title: 'Red header', block: 'h1', styles: {color: '#ff0000'}},
			{title: 'Example 1', inline: 'span', classes: 'example1'},
			{title: 'Example 2', inline: 'span', classes: 'example2'},
			{title: 'Table styles'},
			{title: 'Table row 1', selector: 'tr', classes: 'tablerow1'}
		],

		template_replace_values : {
			username : "Jack Black"
		},

		template_preview_replace_values : {
			username : "Preview user name"
		},

		templates: [ 
			{title: 'Some title 1', description: 'Some desc 1', content: '<strong class="red">My content: {$username}</strong>'}, 
			{title: 'Some title 2', description: 'Some desc 2', url: 'development.html'} 
		],

		setup: function(ed) {
			/*ed.on(
				'Init PreInit PostRender PreProcess PostProcess BeforeExecCommand ExecCommand Activate Deactivate ' +
				'NodeChange SetAttrib Load Save BeforeSetContent SetContent BeforeGetContent GetContent Remove Show Hide' +
				'Change Undo Redo AddUndo BeforeAddUndo', function(e) {
				console.log(e.type, e);
			});*/
		},

		spellchecker_callback: function(method, words, callback) {
			if (method == "spellcheck") {
				var suggestions = {};

				for (var i = 0; i < words.length; i++) {
					suggestions[words[i]] = ["First", "second"];
				}

				callback(suggestions);
			}
		}
	});

	/*  carga de la galeria de imagenes  */
	if( $('div#drop_galeria').length ) { 
	var galeria_up = new Dropzone("div#drop_galeria", 
		{ url: "{{ URL::route('admin.subirImagen') }}",
		  previewTemplate: "<div data-id=\"\" class=\"dz-preview dz-file-preview22\" >\n     <div class=\"dz-details\">\n <img data-dz-thumbnail />\n  <input type=\"hidden\" id=\"escudo-nombre\" value=\"\"></div>\n  <div class=\"dz-progress\"><span class=\"dz-upload\" data-dz-uploadprogress></span></div>\n  <div class=\"dz-success-mark\"><span>✔</span></div>\n  <div class=\"dz-error-mark\"><span>✘</span></div>\n  <div class=\"dz-error-message\"><span data-dz-errormessage></span></div>\n</div>"	
		,
		   init: function() {
					this.on("success", function(file, response) {
	      		file.serverId = response;
	      		$(file.previewElement).data("id",file.serverId); 
    			});
    			this.on("sending", function(file, response, formData) {
	      		formData.append("noticia_id", $("#noticia_id").val()); 
    			});
		    }
		}
	);


	galeria_up.on("complete", function(file) {
	  setTimeout(function() {
	  	var url = JSON.parse(file.xhr.response);
	  	$(file.previewElement).data("id",url);
	  	
	  	$(file.previewElement).find(".dz-success-mark").hide();
	  	cargaImagen(file.serverId,public_path,$(file.previewElement));
	  }, 3000 );

	  file.previewElement.addEventListener("click", function() {
	  	cargaImagen(file.serverId,public_path,$(file.previewElement));
	  });

	});


	function cargaImagen(id, public_path,ob) {
    	$("#info-imagen").show();
    	$.getJSON( "{{ URL::to('cpanel/equipos/json') }}/"+id, function( data ) {
			var infoimagen = $("#info-imagen");
			infoimagen.find("img").attr("src",public_path + "/uploads/noticias/" +data.ruta);
			infoimagen.find(".archivo").html(data.ruta);
			infoimagen.find("input[name='nombre']").val(data.nombre);
			infoimagen.find("input[name='nombre_corto']").val(data.nombre_corto);
			infoimagen.find("textarea[name='descripcion']").val(data.descripcion);
			infoimagen.find("input[name='imagen_id']").val(data.id);
		});
    }

  }

  $(".actDestacado").click(function(event){
  	event.preventDefault();
  	if ( $(this).data("des") == 1 ) {
  		$(this).data("des",0);
  		$(this).html("Poner en coberturas destacadas");
  	}
  	else {
  		$(this).data("des",1);
  		$(this).html("Quitar de coberturas destacadas");
  	}

  	$.post(  "{{ URL::to('cpanel/noticia/actualizar/destacado') }}" , { noticia_id: $(this).data("id"), destacado: $(this).data("des") }) 
  		
  	return false;
  });

  $(".actDestacadoHome").click(function(event){
  	event.preventDefault();
  	if ( $(this).data("des") == 1 ) {
  		$(this).data("des",0);
  		$(this).html("Poner en destacados");
  	}
  	else {
  		$(this).data("des",1);
  		$(this).html("Quitar de destacados");
  	}

  	$.post(  "{{ URL::to('cpanel/noticia/actualizar/destacadoHome') }}" , { noticia_id: $(this).data("id"), destacadoHome: $(this).data("des") }) 
  		
  	return false;
  });
	
	
  $(".btn.btn-info.activar-encuesta").click(function(event) {
  	event.preventDefault();
  	$.post(  "{{ URL::to('cpanel/encuesta/activar') }}" , { encuesta_id: $(this).data("id") });
  	return false;
  });
	

});

</script>

    
