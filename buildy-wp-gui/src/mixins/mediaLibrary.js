export default {
    data: function() {
        return {
            isWordpress: window.wp,
            customMediaLibrary: null,
        }
    },
    methods: {
        initUploader() {
            if ( this.isWordpress ) {
                this.customMediaLibrary = window.wp.media({
                    // Accepts [ 'select', 'post', 'image', 'audio', 'video' ]
                    // Determines what kind of library should be rendered.
                    frame: 'select',
                    // Modal title.
                    title: "'Select Images',",
                    // Enable/disable multiple select
                    multiple: true,
                    // Library wordpress query arguments.
                    library: {
                        order: 'DESC',
                        // [ 'name', 'author', 'date', 'title', 'modified', 'uploadedTo', 'id', 'post__in', 'menuOrder' ]
                        orderby: 'date',
                        // mime type. e.g. 'image', 'image/jpeg'
                        type: 'image',
                        // Searches the attachment title.
                        search: null,
                        // Includes media only uploaded to the specified post (ID)
                        uploadedTo: null // wp.media.view.settings.post.id (for current post ID)
                    },
                    button: {
                        text: 'Done'
                    }
                }); 
                
                this.$emit('mediaSelect');
            }
        },
        openMediaLibrary() {
            if (this.customMediaLibrary) {
                this.customMediaLibrary.open()
            }
        }        
    },
    mounted() {
        this.initUploader();
    },
};