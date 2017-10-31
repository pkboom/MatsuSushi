Vue.component('upload-image-popup', require('./components/upload-image-popup.vue'));

if (document.getElementById('app-upload')) {
	const appUpload = new Vue({ 
		el: '#app-upload',

		created() {
			this.uploaded = false;
		},

		data: {
			uploaded: false,
		},
	})
}