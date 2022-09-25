import Dropzone from 'dropzone';

Dropzone.autoDiscover = false;

// Ubicación del pegado de imagtenes.
const dropzone = new Dropzone('#dropzone', {
	dictDefaultMessage: 'Sube aquí tu imagen',
	acceptedFiles: '.png, .jpg, .jpeg, .gif',
	addRemoveLinks: true,
	dictRemoveFile: 'Borrar imagen',
	maxFiles: 1,
	uploadMultiple: false,

	init: function() {
		// Para mostrar la imagen subida en el formulario de creación del post.
		if (document.querySelector('[name="imagen"]').value.trim()) {
			const imagenPublicada = {};
			imagenPublicada.size = 1234;
			imagenPublicada.name = document.querySelector('[name="imagen"]').value;

			this.options.addedfile.call(this, imagenPublicada);
			this.options.thumbnail.call(this, imagenPublicada, '/uploads/${imagenPublicada.name}');

			imagenPublicada.previewElement.classList.add('dz-success', 'dz-complete');
		}
	}
});

/*
dropzone.on('sending', function(file, xhr, formDate) {
	console.log(file);
});
*/

dropzone.on('success', function(file, respose) {
	/* console.log(respose.imagen); */

	document.querySelector('[name="imagen"]').value = respose.imagen;
});

/*
dropzone.on('error', function(file, respose) {
	console.log(message);
});
*/

dropzone.on('removedfile', function() {
	/* console.log('Archivo eliminado.'); */

	document.querySelector('[name="imagen"]').value = '';
});
