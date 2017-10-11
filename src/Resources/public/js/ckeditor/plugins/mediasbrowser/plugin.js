CKEDITOR.plugins.add('mediasbrowser', {
    lang: 'fr,en',
    icons: 'mediasbrowser',
    init: function (editor) {
        var config = editor.config,
            mediasBrowserRoute = config.mediasBrowserRoute,
            thumbFormat = config.mediasBrowserThumbFormat;
        var route = mediasBrowserRoute.route;
        var route_params = typeof(mediasBrowserRoute.params) != 'undefined' ? mediasBrowserRoute.params : null;

        /*
          Needs ModulesRoutes generated by Manager
        */
        if( typeof(ModulesRoutes.selecter.image) == 'undefined' ){
          console.warn('ModulesRoutes var expected for ckeditor image browser');
          return;
        }


        editor.addCommand('mediasbrowser', {
            exec: function (editor) {

              if( typeof(Foundation.Reveal) !== 'undefined' ){
                var modal = $('<div>',{class: 'large reveal', 'data-reveal': true});
                $('body').append(modal);

                var fndmodal = new Foundation.Reveal(modal);
                window.selectItem = function(module, data) {
                  if( module === 'image'){
                    if( typeof(data.path) != 'undefined' ){
                      editor.insertHtml('<img src="' + data.path + '"/>');
                    }
                  }
                };
              }

                $.ajax({
                    url: ModulesRoutes.selecter.image,
                    xhrFields: {withCredentials: true},
                    headers: {'X-Requested-With': 'XMLHttpRequest'},
                    success: function (content) {
                        modal.html(content);
                        $(modal).foundation('open');
                    },
                });
            }
        });

        if (editor.ui.addButton) {
            editor.ui.addButton('Mediasbrowser', {
                label: editor.lang.mediasbrowser['label'],
                command: 'mediasbrowser',
                toolbar: 'insert',
            });
        }
    }
});
