if("undefined"==typeof jQuery)throw new Error("ZUI requires jQuery");+function(t){"use strict";function e(){var t=document.createElement("bootstrap"),e={WebkitTransition:"webkitTransitionEnd",MozTransition:"transitionend",transition:"transitionend"};for(var o in e)if(void 0!==t.style[o])return{end:e[o]}}t.fn.emulateTransitionEnd=function(e){var o=!1,n=this;t(this).one(t.support.transition.end,function(){o=!0});var i=function(){o||t(n).trigger(t.support.transition.end)};return setTimeout(i,e),this},t(function(){t.support.transition=e()})}(jQuery),+function(t){"use strict";var e='[data-dismiss="alert"]',o=function(o){t(o).on("click",e,this.close)};o.prototype.close=function(e){function o(){a.trigger("closed.bs.alert").remove()}var n=t(this),i=n.attr("data-target");i||(i=n.attr("href"),i=i&&i.replace(/.*(?=#[^\s]*$)/,""));var a=t(i);e&&e.preventDefault(),a.length||(a=n.hasClass("alert")?n:n.parent()),a.trigger(e=t.Event("close.bs.alert")),e.isDefaultPrevented()||(a.removeClass("in"),t.support.transition&&a.hasClass("fade")?a.one(t.support.transition.end,o).emulateTransitionEnd(150):o())};var n=t.fn.alert;t.fn.alert=function(e){return this.each(function(){var n=t(this),i=n.data("bs.alert");i||n.data("bs.alert",i=new o(this)),"string"==typeof e&&i[e].call(n)})},t.fn.alert.Constructor=o,t.fn.alert.noConflict=function(){return t.fn.alert=n,this},t(document).on("click.bs.alert.data-api",e,o.prototype.close)}(window.jQuery),+function(t){"use strict";var e=function(o,n){this.$element=t(o),this.options=t.extend({},e.DEFAULTS,n),this.transitioning=null,this.options.parent&&(this.$parent=t(this.options.parent)),this.options.toggle&&this.toggle()};e.DEFAULTS={toggle:!0},e.prototype.dimension=function(){var t=this.$element.hasClass("width");return t?"width":"height"},e.prototype.show=function(){if(!this.transitioning&&!this.$element.hasClass("in")){var e=t.Event("show.bs.collapse");if(this.$element.trigger(e),!e.isDefaultPrevented()){var o=this.$parent&&this.$parent.find("> .panel > .in");if(o&&o.length){var n=o.data("bs.collapse");if(n&&n.transitioning)return;o.collapse("hide"),n||o.data("bs.collapse",null)}var i=this.dimension();this.$element.removeClass("collapse").addClass("collapsing")[i](0),this.transitioning=1;var a=function(){this.$element.removeClass("collapsing").addClass("in")[i]("auto"),this.transitioning=0,this.$element.trigger("shown.bs.collapse")};if(!t.support.transition)return a.call(this);var s=t.camelCase(["scroll",i].join("-"));this.$element.one(t.support.transition.end,t.proxy(a,this)).emulateTransitionEnd(350)[i](this.$element[0][s])}}},e.prototype.hide=function(){if(!this.transitioning&&this.$element.hasClass("in")){var e=t.Event("hide.bs.collapse");if(this.$element.trigger(e),!e.isDefaultPrevented()){var o=this.dimension();this.$element[o](this.$element[o]())[0].offsetHeight,this.$element.addClass("collapsing").removeClass("collapse").removeClass("in"),this.transitioning=1;var n=function(){this.transitioning=0,this.$element.trigger("hidden.bs.collapse").removeClass("collapsing").addClass("collapse")};return t.support.transition?(this.$element[o](0).one(t.support.transition.end,t.proxy(n,this)).emulateTransitionEnd(350),void 0):n.call(this)}}},e.prototype.toggle=function(){this[this.$element.hasClass("in")?"hide":"show"]()};var o=t.fn.collapse;t.fn.collapse=function(o){return this.each(function(){var n=t(this),i=n.data("bs.collapse"),a=t.extend({},e.DEFAULTS,n.data(),"object"==typeof o&&o);i||n.data("bs.collapse",i=new e(this,a)),"string"==typeof o&&i[o]()})},t.fn.collapse.Constructor=e,t.fn.collapse.noConflict=function(){return t.fn.collapse=o,this},t(document).on("click.bs.collapse.data-api","[data-toggle=collapse]",function(e){var o,n=t(this),i=n.attr("data-target")||e.preventDefault()||(o=n.attr("href"))&&o.replace(/.*(?=#[^\s]+$)/,""),a=t(i),s=a.data("bs.collapse"),r=s?"toggle":n.data(),l=n.attr("data-parent"),d=l&&t(l);s&&s.transitioning||(d&&d.find('[data-toggle=collapse][data-parent="'+l+'"]').not(n).addClass("collapsed"),n[a.hasClass("in")?"addClass":"removeClass"]("collapsed")),a.collapse(r)})}(window.jQuery),+function(t){"use strict";function e(){t(n).remove(),t(i).each(function(e){var n=o(t(this));n.hasClass("open")&&(n.trigger(e=t.Event("hide.bs.dropdown")),e.isDefaultPrevented()||n.removeClass("open").trigger("hidden.bs.dropdown"))})}function o(e){var o=e.attr("data-target");o||(o=e.attr("href"),o=o&&/#/.test(o)&&o.replace(/.*(?=#[^\s]*$)/,""));var n=o&&t(o);return n&&n.length?n:e.parent()}var n=".dropdown-backdrop",i="[data-toggle=dropdown]",a=function(e){t(e).on("click.bs.dropdown",this.toggle)};a.prototype.toggle=function(n){var i=t(this);if(!i.is(".disabled, :disabled")){var a=o(i),s=a.hasClass("open");if(e(),!s){if("ontouchstart"in document.documentElement&&!a.closest(".navbar-nav").length&&t('<div class="dropdown-backdrop"/>').insertAfter(t(this)).on("click",e),a.trigger(n=t.Event("show.bs.dropdown")),n.isDefaultPrevented())return;a.toggleClass("open").trigger("shown.bs.dropdown"),i.focus()}return!1}},a.prototype.keydown=function(e){if(/(38|40|27)/.test(e.keyCode)){var n=t(this);if(e.preventDefault(),e.stopPropagation(),!n.is(".disabled, :disabled")){var a=o(n),s=a.hasClass("open");if(!s||s&&27==e.keyCode)return 27==e.which&&a.find(i).focus(),n.click();var r=t("[role=menu] li:not(.divider):visible a",a);if(r.length){var l=r.index(r.filter(":focus"));38==e.keyCode&&l>0&&l--,40==e.keyCode&&l<r.length-1&&l++,~l||(l=0),r.eq(l).focus()}}}};var s=t.fn.dropdown;t.fn.dropdown=function(e){return this.each(function(){var o=t(this),n=o.data("dropdown");n||o.data("dropdown",n=new a(this)),"string"==typeof e&&n[e].call(o)})},t.fn.dropdown.Constructor=a,t.fn.dropdown.noConflict=function(){return t.fn.dropdown=s,this},t(document).on("click.bs.dropdown.data-api",e).on("click.bs.dropdown.data-api",".dropdown form",function(t){t.stopPropagation()}).on("click.bs.dropdown.data-api",i,a.prototype.toggle).on("keydown.bs.dropdown.data-api",i+", [role=menu]",a.prototype.keydown)}(window.jQuery),+function(t){"use strict";var e=function(e,o){this.options=o,this.$element=t(e),this.$backdrop=this.isShown=null,this.options.remote&&this.$element.load(this.options.remote)};e.DEFAULTS={backdrop:!0,keyboard:!0,show:!0,position:"fit"},e.prototype.toggle=function(t){return this[this.isShown?"hide":"show"](t)},e.prototype.show=function(e){var o=this,n=t.Event("show.bs.modal",{relatedTarget:e});this.$element.trigger(n),this.isShown||n.isDefaultPrevented()||(this.isShown=!0,this.escape(),this.$element.on("click.dismiss.modal",'[data-dismiss="modal"]',t.proxy(this.hide,this)),this.backdrop(function(){var n=t.support.transition&&o.$element.hasClass("fade");if(o.$element.parent().length||o.$element.appendTo(document.body),o.$element.show(),n&&o.$element[0].offsetWidth,o.$element.addClass("in").attr("aria-hidden",!1),o.options.position){var i=o.$element.find(".modal-dialog"),a=Math.max(0,(t(window).height()-i.outerHeight())/2),s="fit"==o.options.position?2*a/3:"center"==o.options.position?a:o.options.position;i.css("margin-top",s)}o.enforceFocus();var r=t.Event("shown.bs.modal",{relatedTarget:e});n?o.$element.find(".modal-dialog").one(t.support.transition.end,function(){o.$element.focus().trigger(r)}).emulateTransitionEnd(300):o.$element.focus().trigger(r)}))},e.prototype.hide=function(e){e&&e.preventDefault(),e=t.Event("hide.bs.modal"),this.$element.trigger(e),this.isShown&&!e.isDefaultPrevented()&&(this.isShown=!1,this.escape(),t(document).off("focusin.bs.modal"),this.$element.removeClass("in").attr("aria-hidden",!0).off("click.dismiss.modal"),t.support.transition&&this.$element.hasClass("fade")?this.$element.one(t.support.transition.end,t.proxy(this.hideModal,this)).emulateTransitionEnd(300):this.hideModal())},e.prototype.enforceFocus=function(){t(document).off("focusin.bs.modal").on("focusin.bs.modal",t.proxy(function(t){this.$element[0]===t.target||this.$element.has(t.target).length||this.$element.focus()},this))},e.prototype.escape=function(){this.isShown&&this.options.keyboard?this.$element.on("keyup.dismiss.bs.modal",t.proxy(function(t){27==t.which&&this.hide()},this)):this.isShown||this.$element.off("keyup.dismiss.bs.modal")},e.prototype.hideModal=function(){var t=this;this.$element.hide(),this.backdrop(function(){t.removeBackdrop(),t.$element.trigger("hidden.bs.modal")})},e.prototype.removeBackdrop=function(){this.$backdrop&&this.$backdrop.remove(),this.$backdrop=null},e.prototype.backdrop=function(e){var o=this.$element.hasClass("fade")?"fade":"";if(this.isShown&&this.options.backdrop){var n=t.support.transition&&o;if(this.$backdrop=t('<div class="modal-backdrop '+o+'" />').appendTo(document.body),this.$element.on("click.dismiss.modal",t.proxy(function(t){t.target===t.currentTarget&&("static"==this.options.backdrop?this.$element[0].focus.call(this.$element[0]):this.hide.call(this))},this)),n&&this.$backdrop[0].offsetWidth,this.$backdrop.addClass("in"),!e)return;n?this.$backdrop.one(t.support.transition.end,e).emulateTransitionEnd(150):e()}else!this.isShown&&this.$backdrop?(this.$backdrop.removeClass("in"),t.support.transition&&this.$element.hasClass("fade")?this.$backdrop.one(t.support.transition.end,e).emulateTransitionEnd(150):e()):e&&e()};var o=t.fn.modal;t.fn.modal=function(o,n){return this.each(function(){var i=t(this),a=i.data("bs.modal"),s=t.extend({},e.DEFAULTS,i.data(),"object"==typeof o&&o);a||i.data("bs.modal",a=new e(this,s)),"string"==typeof o?a[o](n):s.show&&a.show(n)})},t.fn.modal.Constructor=e,t.fn.modal.noConflict=function(){return t.fn.modal=o,this},t(document).on("click.bs.modal.data-api",'[data-toggle="modal"]',function(e){var o=t(this),n=o.attr("href"),i=t(o.attr("data-target")||n&&n.replace(/.*(?=#[^\s]+$)/,""));if(!(i.length<1)){var a=i.data("modal")?"toggle":t.extend({remote:!/#/.test(n)&&n},i.data(),o.data());e.preventDefault(),i.modal(a,this).one("hide",function(){o.is(":visible")&&o.focus()})}}),t(document).on("show.bs.modal",".modal",function(){t(document.body).addClass("modal-open")}).on("hidden.bs.modal",".modal",function(){t(document.body).removeClass("modal-open")})}(window.jQuery),+function(t){"use strict";var e=function(t,e){this.type=this.options=this.enabled=this.timeout=this.hoverState=this.$element=null,this.init("tooltip",t,e)};e.DEFAULTS={animation:!0,placement:"top",selector:!1,template:'<div class="tooltip"><div class="tooltip-arrow"></div><div class="tooltip-inner"></div></div>',trigger:"hover focus",title:"",delay:0,html:!1,container:!1},e.prototype.init=function(e,o,n){this.enabled=!0,this.type=e,this.$element=t(o),this.options=this.getOptions(n);for(var i=this.options.trigger.split(" "),a=i.length;a--;){var s=i[a];if("click"==s)this.$element.on("click."+this.type,this.options.selector,t.proxy(this.toggle,this));else if("manual"!=s){var r="hover"==s?"mouseenter":"focus",l="hover"==s?"mouseleave":"blur";this.$element.on(r+"."+this.type,this.options.selector,t.proxy(this.enter,this)),this.$element.on(l+"."+this.type,this.options.selector,t.proxy(this.leave,this))}}this.options.selector?this._options=t.extend({},this.options,{trigger:"manual",selector:""}):this.fixTitle()},e.prototype.getDefaults=function(){return e.DEFAULTS},e.prototype.getOptions=function(e){return e=t.extend({},this.getDefaults(),this.$element.data(),e),e.delay&&"number"==typeof e.delay&&(e.delay={show:e.delay,hide:e.delay}),e},e.prototype.getDelegateOptions=function(){var e={},o=this.getDefaults();return this._options&&t.each(this._options,function(t,n){o[t]!=n&&(e[t]=n)}),e},e.prototype.enter=function(e){var o=e instanceof this.constructor?e:t(e.currentTarget)[this.type](this.getDelegateOptions()).data("bs."+this.type);return clearTimeout(o.timeout),o.hoverState="in",o.options.delay&&o.options.delay.show?(o.timeout=setTimeout(function(){"in"==o.hoverState&&o.show()},o.options.delay.show),void 0):o.show()},e.prototype.leave=function(e){var o=e instanceof this.constructor?e:t(e.currentTarget)[this.type](this.getDelegateOptions()).data("bs."+this.type);return clearTimeout(o.timeout),o.hoverState="out",o.options.delay&&o.options.delay.hide?(o.timeout=setTimeout(function(){"out"==o.hoverState&&o.hide()},o.options.delay.hide),void 0):o.hide()},e.prototype.show=function(){var e=t.Event("show.bs."+this.type);if(this.hasContent()&&this.enabled){if(this.$element.trigger(e),e.isDefaultPrevented())return;var o=this.tip();this.setContent(),this.options.animation&&o.addClass("fade");var n="function"==typeof this.options.placement?this.options.placement.call(this,o[0],this.$element[0]):this.options.placement,i=/\s?auto?\s?/i,a=i.test(n);a&&(n=n.replace(i,"")||"top"),o.detach().css({top:0,left:0,display:"block"}).addClass(n),this.options.container?o.appendTo(this.options.container):o.insertAfter(this.$element);var s=this.getPosition(),r=o[0].offsetWidth,l=o[0].offsetHeight;if(a){var d=this.$element.parent(),p=n,c=document.documentElement.scrollTop||document.body.scrollTop,h="body"==this.options.container?window.innerWidth:d.outerWidth(),u="body"==this.options.container?window.innerHeight:d.outerHeight(),f="body"==this.options.container?0:d.offset().left;n="bottom"==n&&s.top+s.height+l-c>u?"top":"top"==n&&s.top-c-l<0?"bottom":"right"==n&&s.right+r>h?"left":"left"==n&&s.left-r<f?"right":n,o.removeClass(p).addClass(n)}var g=this.getCalculatedOffset(n,s,r,l);this.applyPlacement(g,n),this.$element.trigger("shown.bs."+this.type)}},e.prototype.applyPlacement=function(t,e){var o,n=this.tip(),i=n[0].offsetWidth,a=n[0].offsetHeight,s=parseInt(n.css("margin-top"),10),r=parseInt(n.css("margin-left"),10);isNaN(s)&&(s=0),isNaN(r)&&(r=0),t.top=t.top+s,t.left=t.left+r,n.offset(t).addClass("in");var l=n[0].offsetWidth,d=n[0].offsetHeight;if("top"==e&&d!=a&&(o=!0,t.top=t.top+a-d),/bottom|top/.test(e)){var p=0;t.left<0&&(p=-2*t.left,t.left=0,n.offset(t),l=n[0].offsetWidth,d=n[0].offsetHeight),this.replaceArrow(p-i+l,l,"left")}else this.replaceArrow(d-a,d,"top");o&&n.offset(t)},e.prototype.replaceArrow=function(t,e,o){this.arrow().css(o,t?50*(1-t/e)+"%":"")},e.prototype.setContent=function(){var t=this.tip(),e=this.getTitle();t.find(".tooltip-inner")[this.options.html?"html":"text"](e),t.removeClass("fade in top bottom left right")},e.prototype.hide=function(){function e(){"in"!=o.hoverState&&n.detach()}var o=this,n=this.tip(),i=t.Event("hide.bs."+this.type);return this.$element.trigger(i),i.isDefaultPrevented()?void 0:(n.removeClass("in"),t.support.transition&&this.$tip.hasClass("fade")?n.one(t.support.transition.end,e).emulateTransitionEnd(150):e(),this.$element.trigger("hidden.bs."+this.type),this)},e.prototype.fixTitle=function(){var t=this.$element;(t.attr("title")||"string"!=typeof t.attr("data-original-title"))&&t.attr("data-original-title",t.attr("title")||"").attr("title","")},e.prototype.hasContent=function(){return this.getTitle()},e.prototype.getPosition=function(){var e=this.$element[0];return t.extend({},"function"==typeof e.getBoundingClientRect?e.getBoundingClientRect():{width:e.offsetWidth,height:e.offsetHeight},this.$element.offset())},e.prototype.getCalculatedOffset=function(t,e,o,n){return"bottom"==t?{top:e.top+e.height,left:e.left+e.width/2-o/2}:"top"==t?{top:e.top-n,left:e.left+e.width/2-o/2}:"left"==t?{top:e.top+e.height/2-n/2,left:e.left-o}:{top:e.top+e.height/2-n/2,left:e.left+e.width}},e.prototype.getTitle=function(){var t,e=this.$element,o=this.options;return t=e.attr("data-original-title")||("function"==typeof o.title?o.title.call(e[0]):o.title)},e.prototype.tip=function(){return this.$tip=this.$tip||t(this.options.template)},e.prototype.arrow=function(){return this.$arrow=this.$arrow||this.tip().find(".tooltip-arrow")},e.prototype.validate=function(){this.$element[0].parentNode||(this.hide(),this.$element=null,this.options=null)},e.prototype.enable=function(){this.enabled=!0},e.prototype.disable=function(){this.enabled=!1},e.prototype.toggleEnabled=function(){this.enabled=!this.enabled},e.prototype.toggle=function(e){var o=e?t(e.currentTarget)[this.type](this.getDelegateOptions()).data("bs."+this.type):this;o.tip().hasClass("in")?o.leave(o):o.enter(o)},e.prototype.destroy=function(){this.hide().$element.off("."+this.type).removeData("bs."+this.type)};var o=t.fn.tooltip;t.fn.tooltip=function(o){return this.each(function(){var n=t(this),i=n.data("bs.tooltip"),a="object"==typeof o&&o;i||n.data("bs.tooltip",i=new e(this,a)),"string"==typeof o&&i[o]()})},t.fn.tooltip.Constructor=e,t.fn.tooltip.noConflict=function(){return t.fn.tooltip=o,this}}(window.jQuery),+function(t){"use strict";var e=function(t,e){this.init("popover",t,e)};if(!t.fn.tooltip)throw new Error("Popover requires tooltip.js");e.DEFAULTS=t.extend({},t.fn.tooltip.Constructor.DEFAULTS,{placement:"right",trigger:"click",content:"",template:'<div class="popover"><div class="arrow"></div><h3 class="popover-title"></h3><div class="popover-content"></div></div>'}),e.prototype=t.extend({},t.fn.tooltip.Constructor.prototype),e.prototype.constructor=e,e.prototype.getDefaults=function(){return e.DEFAULTS},e.prototype.setContent=function(){var t=this.tip(),e=this.getTarget();if(e)return e.find(".arrow").length<1&&t.addClass("no-arrow"),t.html(e.html()),void 0;var o=this.getTitle(),n=this.getContent();t.find(".popover-title")[this.options.html?"html":"text"](o),t.find(".popover-content")[this.options.html?"html":"text"](n),t.removeClass("fade top bottom left right in"),t.find(".popover-title").html()||t.find(".popover-title").hide()},e.prototype.hasContent=function(){return this.getTarget()||this.getTitle()||this.getContent()},e.prototype.getContent=function(){var t=this.$element,e=this.options;return t.attr("data-content")||("function"==typeof e.content?e.content.call(t[0]):e.content)},e.prototype.getTarget=function(){var e=this.$element,o=this.options,n=e.attr("data-target")||("function"==typeof o.target?o.target.call(e[0]):o.target);return n?"$next"==n?e.next(".popover"):t(n):!1},e.prototype.arrow=function(){return this.$arrow=this.$arrow||this.tip().find(".arrow")},e.prototype.tip=function(){return this.$tip||(this.$tip=t(this.options.template)),this.$tip};var o=t.fn.popover;t.fn.popover=function(o){return this.each(function(){var n=t(this),i=n.data("bs.popover"),a="object"==typeof o&&o;i||n.data("bs.popover",i=new e(this,a)),"string"==typeof o&&i[o]()})},t.fn.popover.Constructor=e,t.fn.popover.noConflict=function(){return t.fn.popover=o,this}}(window.jQuery),+function(t){"use strict";var e=function(e){this.element=t(e)};e.prototype.show=function(){var e=this.element,o=e.closest("ul:not(.dropdown-menu)"),n=e.attr("data-target");if(n||(n=e.attr("href"),n=n&&n.replace(/.*(?=#[^\s]*$)/,"")),!e.parent("li").hasClass("active")){var i=o.find(".active:last a")[0],a=t.Event("show.bs.tab",{relatedTarget:i});if(e.trigger(a),!a.isDefaultPrevented()){var s=t(n);this.activate(e.parent("li"),o),this.activate(s,s.parent(),function(){e.trigger({type:"shown.bs.tab",relatedTarget:i})})}}},e.prototype.activate=function(e,o,n){function i(){a.removeClass("active").find("> .dropdown-menu > .active").removeClass("active"),e.addClass("active"),s?(e[0].offsetWidth,e.addClass("in")):e.removeClass("fade"),e.parent(".dropdown-menu")&&e.closest("li.dropdown").addClass("active"),n&&n()}var a=o.find("> .active"),s=n&&t.support.transition&&a.hasClass("fade");s?a.one(t.support.transition.end,i).emulateTransitionEnd(150):i(),a.removeClass("in")};var o=t.fn.tab;t.fn.tab=function(o){return this.each(function(){var n=t(this),i=n.data("bs.tab");i||n.data("bs.tab",i=new e(this)),"string"==typeof o&&i[o]()})},t.fn.tab.Constructor=e,t.fn.tab.noConflict=function(){return t.fn.tab=o,this},t(document).on("click.bs.tab.data-api",'[data-toggle="tab"], [data-toggle="pill"]',function(e){e.preventDefault(),t(this).tab("show")})}(window.jQuery),+function(t,e,o,n){"use strict";function i(e){var o=e.data("url");o&&(e.addClass("panel-loading").find(".panel-heading .icon-refresh,.panel-heading .icon-repeat").addClass("icon-spin"),t.ajax({url:o,dataType:"html"}).done(function(t){e.find(".panel-body").html(t)}).fail(function(){e.addClass("panel-error")}).always(function(){e.removeClass("panel-loading"),e.find(".panel-heading .icon-refresh,.panel-heading .icon-repeat").removeClass("icon-spin")}))}var a=function(e,o){this.$=t(e),this.options=this.getOptions(o),this.draggable=this.$.hasClass("dashboard-draggable")||this.options.draggable,this.init()};a.DEFAULTS={height:360},a.prototype.getOptions=function(e){return e=t.extend({},a.DEFAULTS,this.$.data(),e)},a.prototype.handleRemoveEvent=function(){var e=this.options.afterPanelRemoved,o=this.options.panelRemovingTip;this.$.find(".remove-panel").click(function(){var n=t(this).closest(".panel"),i=n.data("name")||n.find(".panel-heading").text().replace("\n","").replace(/(^\s*)|(\s*$)/g,""),a=n.attr("data-id");(void 0==o||confirm(o.format(i)))&&(n.parent().remove(),e&&t.isFunction(e)&&e(a))})},a.prototype.handleRefreshEvent=function(){this.$.find(".refresh-panel").click(function(){var e=t(this).closest(".panel");i(e)})},a.prototype.handleDraggable=function(){var e=this.$,n=this.options.afterOrdered;this.$.addClass("dashboard-draggable"),this.$.find(".panel-actions").mousedown(function(t){t.preventDefault(),t.stopPropagation()}),this.$.find(".panel-heading").mousedown(function(i){function a(o){var n=p.data("mouseOffset");p.css({left:o.pageX-n.x,top:o.pageY-n.y}),d.find(".dragging-in").removeClass("dragging-in");var i=!1;d.children().each(function(){var n=t(this);if(n.hasClass("dragging-col-holder"))return i=!0,!0;var a=n.children(".panel"),s=a.offset(),r=a.width(),l=a.height(),p=s.left,c=s.top,h=o.pageX,f=o.pageY;return h>p&&f>c&&p+r>h&&c+l>f?(d.find(".dragging-col"),n.addClass("dragging-in"),i?u.insertAfter(n):u.insertBefore(n),e.addClass("dashboard-holding"),!1):void 0}),o.preventDefault()}function s(i){var l=r.data("order");r.parent().insertAfter(u);var c=0,h={};d.children(":not(.dragging-col-holder)").each(function(){var e=t(this).children(".panel");e.data("order",++c),h[e.attr("id")]=c,e.parent().attr("data-order",c)}),l!=h[r.attr("id")]&&(d.data("orders",h),n&&t.isFunction(n)&&n(h)),p.remove(),e.removeClass("dashboard-holding"),e.find(".dragging-col").removeClass("dragging-col"),e.find(".panel-dragging").removeClass("panel-dragging"),d.find(".dragging-in").removeClass("dragging-in"),e.removeClass("dashboard-dragging"),t(o).unbind("mousemove",a).unbind("mouseup",s),i.preventDefault()}var r=t(this).closest(".panel"),l=r.parent(),d=r.closest(".row"),p=r.clone().addClass("panel-dragging-shadow"),c=r.offset(),h=e.offset(),u=d.find(".dragging-col-holder");u.length||(u=t("<div class='dragging-col-holder'><div class='panel'></div></div>").addClass(d.children().attr("class")).removeClass("dragging-col").appendTo(d)),u.insertBefore(l).find(".panel").replaceWith(r.clone().addClass("panel-dragging panel-dragging-holder")),e.addClass("dashboard-dragging"),r.addClass("panel-dragging").parent().addClass("dragging-col"),p.css({left:c.left-h.left,top:c.top-h.top,width:r.width(),height:r.height()}).appendTo(e).data("mouseOffset",{x:i.pageX-c.left+h.left,y:i.pageY-c.top+h.top}),t(o).bind("mousemove",a).bind("mouseup",s),i.preventDefault()})},a.prototype.handlePanelPadding=function(){this.$.find(".panel-body > table, .panel-body > .list-group").closest(".panel-body").addClass("no-padding")},a.prototype.handlePanelHeight=function(){var e=this.options.height;this.$.find(".row").each(function(){var o=t(this),i=o.find(".panel"),a=o.data("height")||e;"number"!=typeof a&&(a=0,i.each(function(){a=n.max(a,t(this).innerHeight())})),i.each(function(){var e=t(this);e.find(".panel-body").css("height",a-e.find(".panel-heading").outerHeight()-2)})})},a.prototype.init=function(){this.handlePanelHeight(),this.handlePanelPadding(),this.handleRemoveEvent(),this.handleRefreshEvent(),this.draggable&&this.handleDraggable();var e=0;this.$.find(".panel").each(function(){var o=t(this);o.data("order",++e),o.attr("id")||o.attr("id","panel"+e),o.attr("data-id")||o.attr("data-id",e),i(o)})},t.fn.dashboard=function(e){return this.each(function(){var o=t(this),n=o.data("zui.dashboard"),i="object"==typeof e&&e;n||o.data("zui.dashboard",n=new a(this,i)),"string"==typeof e&&n[e]()})},t.fn.dashboard.Constructor=a}(jQuery,window,document,Math),+function(t,e){"use strict";var o=function(e,o){this.$=t(e),this.options=this.getOptions(o),this.init()};o.DEFAULTS={},o.prototype.getOptions=function(e){return e=t.extend({},o.DEFAULTS,this.$.data(),e)},o.prototype.init=function(){this.handleRowClickable()},o.prototype.handleRowClickable=function(){this.$,this.$.find('tr[data-url]:not(".app-btn") td:not(".actions")').click(function(o){if(!t(o.target).is("a, .caret")){var n=t(this).closest("tr").data("url");n&&(e.location=n)}})},t.fn.dataTable=function(e){return this.each(function(){var n=t(this),i=n.data("zui.dataTable"),a="object"==typeof e&&e;i||n.data("zui.dataTable",i=new o(this,a)),"string"==typeof e&&i[e]()})},t.fn.dataTable.Constructor=o,t(function(){t("table.table-data").dataTable()})}(jQuery,window,document,Math),function(t,e){"use strict";"function"==typeof define&&define.amd?define(["jquery"],e):"object"==typeof exports?module.exports=e(require("jquery")):t.bootbox=e(t.jQuery)}(this,function t(e,o){"use strict";function n(){var t;if("undefined"!=typeof config&&config.clientLang)t=config.clientLang;else{var o=e("html").attr("lang");t=o?o:"en"}return t.replace(/-/,"_").toLowerCase()}function i(t){var e=v[g.locale];return e?e[t]:v.en[t]}function a(t,o,n){t.stopPropagation(),t.preventDefault();var i=e.isFunction(n)&&n(t)===!1;i||o.modal("hide")}function s(t){var e,o=0;for(e in t)o++;return o}function r(t,o){var n=0;e.each(t,function(t,e){o(t,e,n++)})}function l(t){var o,n;if("object"!=typeof t)throw new Error("Please supply an object of options");if(!t.message)throw new Error("Please specify a message");return t=e.extend({},g,t),t.buttons||(t.buttons={}),t.backdrop=t.backdrop?"static":!1,o=t.buttons,n=s(o),r(o,function(t,i,a){if(e.isFunction(i)&&(i=o[t]={callback:i}),"object"!==e.type(i))throw new Error("button with key "+t+" must be an object");i.label||(i.label=t),i.className||(i.className=2>=n&&a===n-1?"btn-primary":"btn-default")}),t}function d(t,e){var o=t.length,n={};if(1>o||o>2)throw new Error("Invalid argument length");return 2===o||"string"==typeof t[0]?(n[e[0]]=t[0],n[e[1]]=t[1]):n=t[0],n}function p(t,o,n){return e.extend(!0,{},t,d(o,n))}function c(t,e,o,n){var i={className:"bootbox-"+t,buttons:h.apply(null,e)};return u(p(i,n,o),e)}function h(){for(var t={},e=0,o=arguments.length;o>e;e++){var n=arguments[e],a=n.toLowerCase(),s=n.toUpperCase();t[a]={label:i(s)}}return t}function u(t,e){var n={};return r(e,function(t,e){n[e]=!0}),r(t.buttons,function(t){if(n[t]===o)throw new Error("button key "+t+" is not allowed (options are "+e.join("\n")+")")}),t}var f={dialog:"<div class='bootbox modal' tabindex='-1' role='dialog'><div class='modal-dialog'><div class='modal-content'><div class='modal-body'><div class='bootbox-body'></div></div></div></div></div>",header:"<div class='modal-header'><h4 class='modal-title'></h4></div>",footer:"<div class='modal-footer'></div>",closeButton:"<button type='button' class='bootbox-close-button close' data-dismiss='modal' aria-hidden='true'>&times;</button>",form:"<form class='bootbox-form'></form>",inputs:{text:"<input class='bootbox-input bootbox-input-text form-control' autocomplete=off type=text />",textarea:"<textarea class='bootbox-input bootbox-input-textarea form-control'></textarea>",email:"<input class='bootbox-input bootbox-input-email form-control' autocomplete='off' type='email' />",select:"<select class='bootbox-input bootbox-input-select form-control'></select>",checkbox:"<div class='checkbox'><label><input class='bootbox-input bootbox-input-checkbox' type='checkbox' /></label></div>",date:"<input class='bootbox-input bootbox-input-date form-control' autocomplete=off type='date' />",time:"<input class='bootbox-input bootbox-input-time form-control' autocomplete=off type='time' />",number:"<input class='bootbox-input bootbox-input-number form-control' autocomplete=off type='number' />",password:"<input class='bootbox-input bootbox-input-password form-control' autocomplete='off' type='password' />"}},g={locale:n(),backdrop:!0,animate:!0,className:null,closeButton:!0,show:!0,container:"body"},m={};m.alert=function(){var t;if(t=c("alert",["ok"],["message","callback"],arguments),t.callback&&!e.isFunction(t.callback))throw new Error("alert requires callback property to be a function when provided");return t.buttons.ok.callback=t.onEscape=function(){return e.isFunction(t.callback)?t.callback():!0},m.dialog(t)},m.confirm=function(){var t;if(t=c("confirm",["cancel","confirm"],["message","callback"],arguments),t.buttons.cancel.callback=t.onEscape=function(){return t.callback(!1)},t.buttons.confirm.callback=function(){return t.callback(!0)},!e.isFunction(t.callback))throw new Error("confirm requires a callback");return m.dialog(t)},m.prompt=function(){var t,n,i,a,s,l,d;a=e(f.form),n={className:"bootbox-prompt",buttons:h("cancel","confirm"),value:"",inputType:"text"},t=u(p(n,arguments,["title","callback"]),["cancel","confirm"]),l=t.show===o?!0:t.show;var c=["date","time","number"],g=document.createElement("input");if(g.setAttribute("type",t.inputType),c[t.inputType]&&(t.inputType=g.type),t.message=a,t.buttons.cancel.callback=t.onEscape=function(){return t.callback(null)},t.buttons.confirm.callback=function(){var o;switch(t.inputType){case"text":case"textarea":case"email":case"select":case"date":case"time":case"number":case"password":o=s.val();break;case"checkbox":var n=s.find("input:checked");o=[],r(n,function(t,n){o.push(e(n).val())})}return t.callback(o)},t.show=!1,!t.title)throw new Error("prompt requires a title");if(!e.isFunction(t.callback))throw new Error("prompt requires a callback");if(!f.inputs[t.inputType])throw new Error("invalid prompt type");switch(s=e(f.inputs[t.inputType]),t.inputType){case"text":case"textarea":case"email":case"date":case"time":case"number":case"password":s.val(t.value);break;case"select":var v={};if(d=t.inputOptions||[],!d.length)throw new Error("prompt with select requires options");r(d,function(t,n){var i=s;if(n.value===o||n.text===o)throw new Error("given options in wrong format");n.group&&(v[n.group]||(v[n.group]=e("<optgroup/>").attr("label",n.group)),i=v[n.group]),i.append("<option value='"+n.value+"'>"+n.text+"</option>")}),r(v,function(t,e){s.append(e)}),s.val(t.value);break;case"checkbox":var b=e.isArray(t.value)?t.value:[t.value];if(d=t.inputOptions||[],!d.length)throw new Error("prompt with checkbox requires options");if(!d[0].value||!d[0].text)throw new Error("given options in wrong format");s=e("<div/>"),r(d,function(o,n){var i=e(f.inputs[t.inputType]);i.find("input").attr("value",n.value),i.find("label").append(n.text),r(b,function(t,e){e===n.value&&i.find("input").prop("checked",!0)}),s.append(i)})}return t.placeholder&&s.attr("placeholder",t.placeholder),t.pattern&&s.attr("pattern",t.pattern),a.append(s),a.on("submit",function(t){t.preventDefault(),t.stopPropagation(),i.find(".btn-primary").click()}),i=m.dialog(t),i.off("shown.bs.modal"),i.on("shown.bs.modal",function(){s.focus()}),l===!0&&i.modal("show"),i},m.dialog=function(t){t=l(t);var o=e(f.dialog),n=o.find(".modal-dialog"),i=o.find(".modal-body"),s=t.buttons,d="",p={onEscape:t.onEscape};if(r(s,function(t,e){d+="<button data-bb-handler='"+t+"' type='button' class='btn "+e.className+"'>"+e.label+"</button>",p[t]=e.callback}),i.find(".bootbox-body").html(t.message),t.animate===!0&&o.addClass("fade"),t.className&&o.addClass(t.className),"large"===t.size&&n.addClass("modal-lg"),"small"===t.size&&n.addClass("modal-sm"),t.title&&i.before(f.header),t.closeButton){var c=e(f.closeButton);t.title?o.find(".modal-header").prepend(c):c.css("margin-top","-10px").prependTo(i)}return t.title&&o.find(".modal-title").html(t.title),d.length&&(i.after(f.footer),o.find(".modal-footer").html(d)),o.on("hidden.bs.modal",function(t){t.target===this&&o.remove()}),o.on("shown.bs.modal",function(){o.find(".btn-primary:first").focus()
}),o.on("escape.close.bb",function(t){p.onEscape&&a(t,o,p.onEscape)}),o.on("click",".modal-footer button",function(t){var n=e(this).data("bb-handler");a(t,o,p[n])}),o.on("click",".bootbox-close-button",function(t){a(t,o,p.onEscape)}),o.on("keyup",function(t){27===t.which&&o.trigger("escape.close.bb")}),e(t.container).append(o),o.modal({backdrop:t.backdrop,keyboard:!1,show:!1}),t.show&&o.modal("show"),o},m.setDefaults=function(){var t={};2===arguments.length?t[arguments[0]]=arguments[1]:t=arguments[0],e.extend(g,t)},m.hideAll=function(){e(".bootbox").modal("hide")};var v={en:{OK:"OK",CANCEL:"Cancel",CONFIRM:"OK"},zh_cn:{OK:"OK",CANCEL:"取消",CONFIRM:"确认"},zh_tw:{OK:"OK",CANCEL:"取消",CONFIRM:"確認"}};return m.init=function(o){return t(o||e)},m}),String.prototype.format=function(t){var e=this;if(arguments.length>0){var o;if(1==arguments.length&&"object"==typeof t)for(var n in t)void 0!=t[n]&&(o=new RegExp("({"+n+"})","g"),e=e.replace(o,t[n]));else for(var i=0;i<arguments.length;i++)void 0!=arguments[i]&&(o=new RegExp("({["+i+"]})","g"),e=e.replace(o,arguments[i]))}return e},String.prototype.isNum=function(t){if(null!=t){var e,o;return o=/\d*/i,e=t.match(o),e==t?!0:!1}return!1},Date.prototype.format=function(t){var e={"M+":this.getMonth()+1,"d+":this.getDate(),"h+":this.getHours(),"m+":this.getMinutes(),"s+":this.getSeconds(),"q+":Math.floor((this.getMonth()+3)/3),"S+":this.getMilliseconds()};/(y+)/i.test(t)&&(t=t.replace(RegExp.$1,(this.getFullYear()+"").substr(4-RegExp.$1.length)));for(var o in e)new RegExp("("+o+")").test(t)&&(t=t.replace(RegExp.$1,1==RegExp.$1.length?e[o]:("00"+e[o]).substr((""+e[o]).length)));return t},+function(t,e,o){"$:nomunge";function n(){i=e[r](function(){a.each(function(){var e=t(this),o=e.width(),n=e.height(),i=t.data(this,d);(o!==i.w||n!==i.h)&&e.trigger(l,[i.w=o,i.h=n])}),n()},s[p])}var i,a=t([]),s=t.resize=t.extend(t.resize,{}),r="setTimeout",l="resize",d=l+"-special-event",p="delay",c="throttleWindow";s[p]=250,s[c]=!0,t.event.special[l]={setup:function(){if(!s[c]&&this[r])return!1;var e=t(this);a=a.add(e),t.data(this,d,{w:e.width(),h:e.height()}),1===a.length&&n()},teardown:function(){if(!s[c]&&this[r])return!1;var e=t(this);a=a.not(e),e.removeData(d),a.length||clearTimeout(i)},add:function(e){function n(e,n,a){var s=t(this),r=t.data(this,d);r.w=n!==o?n:s.width(),r.h=a!==o?a:s.height(),i.apply(this,arguments)}if(!s[c]&&this[r])return!1;var i;return t.isFunction(e)?(i=e,n):(i=e.handler,e.handler=n,void 0)}}}(jQuery,this),+function(t,e,o){"use strict";var n=function(e,o){this.$=t(e),this.options=this.getOptions(o),this.init()};n.DEFAULTS={container:"body",flex:!1},n.prototype.getOptions=function(e){return e=t.extend({},n.DEFAULTS,this.$.data(),e)},n.prototype.init=function(){this.handleMouseEvents()},n.prototype.handleMouseEvents=function(){var e=this.$,n=this.options;e.mousedown(function(i){function a(o){null==p&&(p=e.clone().removeClass("drag-from").addClass("drag-shadow").css({position:"absolute",left:h.left-g.left,top:h.left-g.left,transition:"none"}).appendTo(c),e.addClass("dragging"),n.hasOwnProperty("start")&&t.isFunction(n.start)&&n.start({event:o,element:e}));var i=o.pageX,a=o.pageY;p.css({left:o.pageX-m.x,top:o.pageY-m.y}),u=!1;var s=-1,r=!1;n.flex||l.removeClass("drop-to"),l.each(function(o){var p=t(this),c=p.offset(),h=p.width(),g=p.height(),m=c.left,v=c.top;return i>m&&a>v&&m+h>i&&v+g>a?(u=!0,e.data("id")!=p.data("id")&&(f=!1),(null==d||d.data("id")!=p.data("id")&&!f)&&(r=!0),d=p,s=o,n.flex&&l.removeClass("drop-to"),p.addClass("drop-to"),!1):void 0}),n.flex?null!=d&&d.length&&(u=!0):(e.toggleClass("drop-in",u),p.toggleClass("drop-in",u)),n.hasOwnProperty("drag")&&t.isFunction(n.drag)&&n.drag({event:o,isIn:u,target:d,element:e,isNew:r,selfTarget:f})}function s(i){if(null==p)return e.removeClass("drag-from"),t(o).unbind("mousemove",a).unbind("mouseup",s),void 0;u||(d=null);var r=!0;if(n.hasOwnProperty("beforeDrop")&&t.isFunction(n.beforeDrop)){var r=n.beforeDrop({event:i,isIn:u,target:d,element:e,isNew:isNew,selfTarget:f});r=void 0==r||r?!0:!1}r&&u&&n.hasOwnProperty("drop")&&t.isFunction(n.drop)&&n.drop({event:i,target:d,element:e,isNew:!f&&null!=d}),t(o).unbind("mousemove",a).unbind("mouseup",s),l.removeClass("drop-to"),e.removeClass("dragging").removeClass("drag-from"),p.remove(),n.hasOwnProperty("finish")&&t.isFunction(n.finish)&&n.finish({event:i,target:d,element:e,isNew:!f&&null!=d}),i.preventDefault()}if(n.hasOwnProperty("before")&&t.isFunction(n.before)){var r=n.before({event:i,element:e});if(void 0!=r&&!r)return}var l=t(n.target),d=null,p=null,c=t(n.container),h=e.offset(),u=!1,f=!0,g=c.offset(),m={x:i.pageX-h.left+g.left,y:i.pageY-h.top+g.top};e.addClass("drag-from"),t(o).bind("mousemove",a).bind("mouseup",s),i.preventDefault()})},t.fn.droppable=function(e){return this.each(function(){var o=t(this),i=o.data("zui.droppable"),a="object"==typeof e&&e;i||o.data("zui.droppable",i=new n(this,a)),"string"==typeof e&&i[e]()})},t.fn.droppable.Constructor=n}(jQuery,window,document,Math),+function(t){"use strict";if(!t.fn.droppable)throw new Error("droppable requires for boards");var e=function(e,o){this.$=t(e),this.options=this.getOptions(o),this.getLang(),this.init()};e.DEFAULTS={lang:"zh-cn",langs:{"zh-cn":{appendToTheEnd:"移动到末尾"},"zh-tw":{appendToTheEnd:"移动到末尾"},en:{appendToTheEnd:"Move to the end."}}},e.prototype.getOptions=function(o){return o=t.extend({},e.DEFAULTS,this.$.data(),o)},e.prototype.getLang=function(){if(!this.options.lang){if("undefined"!=typeof config&&config.clientLang)this.options.lang=config.clientLang;else{var o=t("html").attr("lang");this.options.lang=o?o:"en"}this.options.lang=this.options.lang.replace(/-/,"_").toLowerCase()}this.lang=this.options.langs[this.options.lang]||this.options.langs[e.DEFAULTS.lang]},e.prototype.init=function(){var e=1,o=this.lang;this.$.find('.board-item:not(".disable-drop"), .board:not(".disable-drop")').each(function(){var n=t(this);n.attr("id")?n.attr("data-id",n.attr("id")):n.attr("data-id")||n.attr("data-id",e++),n.hasClass("board")&&n.find(".board-list").append('<div class="board-item board-item-empty"><i class="icon-plus"></i> {appendToTheEnd}</div>'.format(o)).append('<div class="board-item board-item-shadow"></div>'.format(o))}),this.bind()},e.prototype.bind=function(t){var e=this.$;"undefined"==typeof t&&(t=e.find('.board-item:not(".disable-drop, .board-item-shadow")')),t.droppable({target:'.board-item:not(".disable-drop, .board-item-shadow")',flex:!0,start:function(t){e.addClass("dragging").find(".board-item-shadow").height(t.element.outerHeight())},drag:function(t){if(e.find(".board.drop-in-empty").removeClass("drop-in-empty"),t.isIn){var o=t.target.closest(".board").addClass("drop-in"),n=o.find(".board-item-shadow"),i=t.target;e.addClass("drop-in").find(".board.drop-in").not(o).removeClass("drop-in"),n.insertBefore(i),o.toggleClass("drop-in-empty",i.hasClass("board-item-empty"))}},drop:function(t){t.isNew&&t.element.insertBefore(t.target)},finish:function(){e.removeClass("dragging").removeClass("drop-in").find(".board.drop-in").removeClass("drop-in")}})},t.fn.boards=function(o){return this.each(function(){var n=t(this),i=n.data("zui.boards"),a="object"==typeof o&&o;i||n.data("zui.boards",i=new e(this,a)),"string"==typeof o&&i[o]()})},t.fn.boards.Constructor=e,t(function(){t('[data-toggle="boards"]').boards()})}(jQuery,window,document,Math);