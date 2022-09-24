import Dropzone from 'dropzone';

Dropzone.autoDiscover = false;

// Ubicación del pegado de imagtenes.
const dropzone = new Dropzone('#dropzone', {
	dictDefaultMessage: 'Sube aquí tu imagen',
	acceptedFiles: '.png, .jpg, .jpeg, .gif',
	addRemoveLinks: true,
	dictRemoveFile: 'Borrar imagen',
	maxFiles: 1,
	uploadMultiple: false
});

dropzone.on('sending', function(file, xhr, formDate) {
	console.log(file);
});

dropzone.on('success', function(file, respose) {
	console.log(respose);
});

dropzone.on('error', function(file, respose) {
	console.log(message);
});

dropzone.on('removedfile', function() {
	console.log('Archivo eliminado.');
});
