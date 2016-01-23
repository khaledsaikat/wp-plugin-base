(function($) {
    var plugin_base = {
        init: function() {
            that = this;
            this.load();
            this.events();
        },

        load: function() {},

        events: function() {},
    };

    $(function() {
        plugin_base.init();
    });
})(jQuery);
