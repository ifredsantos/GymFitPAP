(function($, window, document, location, navigator) {

    /* jshint laxbreak: true, expr: true */
    "use strict";

    // init objects
    var Vojtys = window.Vojtys || {};
    Vojtys.Forms = Vojtys.Forms || {};
    Vojtys.Forms.Croppie = Vojtys.Forms.Croppie || {};

    // check dependences
    if (Croppie === undefined) {
        console.error('Plugin "croppie.js" is missing!');
        return;
    } else if ($.nette === undefined) {
        console.error('Plugin "nette.ajax.js" is missing!.');
        return;
    } else if (window.FileReader === undefined) {
        alert(t('Váš prohlížeč je zastaralý, aplikace nebude pracovat správně.'));
    }

    $.fn.vojtysFormsCroppie = function() {
        return this.each(function() {
            var $this = $(this);
            var settings = $.extend({}, $.fn.vojtysFormsCroppie.defaults, $this.data('settings'));

            // init vojtys croppie
            if (!$this.data('vojtys-forms-croppie')) {
                $this.data('vojtys-forms-croppie', (new Vojtys.Forms.Croppie.initCroppie($this, settings)));
                $this.hide();
            }
        });
    };

    /**
     * Init Croppie
     *
     * @param $element
     * @param options
     * @returns {*}
     * @constructor
     */
    Vojtys.Forms.Croppie.initCroppie = function($element, options) {
        var $preview = $element.croppie(options);
        var $file = $preview.parent('.croppie-wrapper').find('.croppie-upload-btn');

        $file.off('change');
        $file.on('change', function(e) {
            Vojtys.Forms.Croppie.readFile(this, $preview);
        });
        Vojtys.Forms.Croppie.addEvents($preview);
        return $preview;
    };

    /**
     * Add Croppie events
     *
     * @param $croppie
     */
    Vojtys.Forms.Croppie.addEvents = function($croppie) {
        $croppie.on('update.croppie', function(ev, data) {
            Vojtys.Forms.Croppie.getResult($croppie);
        });
    };

    /**
     * Get canvas image result
     *
     * @param $croppie
     */
    Vojtys.Forms.Croppie.getResult = function ($croppie) {
        var $hidden = $croppie.parent('.croppie-wrapper').find('.croppie-value');
        var size = $croppie.data('result-size');

        $croppie.croppie('result', {
            type: 'canvas',
            size: size
        }).then(function (resp) {
            $hidden.val(JSON.stringify({
                image: resp,
                fileinfo: Vojtys.Forms.Croppie.fileInfo
            }));
        }).catch(function(error) {
            console.error(error);
        });
    };

    /**
     * Change croppie viewport
     *
     * @param $croppieEl
     * @param w
     * @param h
     */
    Vojtys.Forms.Croppie.changeViewport = function($croppieEl, w, h) {

        // reset croppie
        Vojtys.Forms.Croppie.reset($croppieEl);

        var settings = $croppieEl.data('settings');
        settings.viewport.width = w;
        settings.viewport.height = h;
        settings.boundary.width = w +100;
        settings.boundary.height = h +100;

        // init croppie
        Vojtys.Forms.Croppie.initCroppie($croppieEl, settings);
    };

    /**
     * Destroy croppie and detach events
     *
     * @param $croppieEl
     */
    Vojtys.Forms.Croppie.reset = function ($croppieEl) {
        var $file = $croppieEl.parent('.croppie-wrapper').find('.croppie-upload-btn');
        $file.val('');
        $file.off('change');
        $croppieEl.off('update.croppie');
        $croppieEl.croppie('destroy');
        $croppieEl.hide();
    };

    /**
     * Read and bind file with croppie
     *
     * @param input
     * @param preview
     */
    Vojtys.Forms.Croppie.readFile = function(input, preview) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function (event) {
                Vojtys.Forms.Croppie.fileInfo = {
                    'name': input.files[0].name,
                    'type': input.files[0].type
                };
                preview.show();
                preview.croppie('bind', {
                    url: event.target.result,
                    zoom: true
                }).then(function (resp) {
                    Vojtys.Forms.Croppie.getResult(preview);
                }).catch(function(error) {
                    console.error(error);
                });
            };
            reader.readAsDataURL(input.files[0]);
        }
    };

    // load Croppie
    Vojtys.Forms.Croppie.load = function() {
        $('[data-vojtys-forms-croppie]').vojtysFormsCroppie();
    };

    // autoload
    Vojtys.Forms.Croppie.load();

    // file info
    Vojtys.Forms.Croppie.fileInfo = {};

    // default settions
    $.fn.vojtysFormsCroppie.defaults = {};

    // assign object do DOM
    window.Vojtys = Vojtys;

    // init Croppie if nette.ajax is success
    $.nette.ext('VojtysCroppieLiveEvent', {
        success: function () {
            Vojtys.Forms.Croppie.load();
        }
    });

    // return Objects
    return Vojtys;

    // Immediately invoke function with default parameters
})(jQuery, window, document, location, navigator);