/* Ips lib */
+function($, window, document, Math)
{
    "use strict";

    /* Global variables */
    var desktopPos       = {x: 40, y: 0},
        fullscreenMode   = false,
        windowIdSeed     = 0,
        windowIdTeamplate= 'WID{0}',
        windowZIndexSeed = 100,
        defaultWindowPos = {x: 110, y: 20},
        entriesConfigs   = null,
        entries          = null,
        desktop          = null,
        windows          = null,
        windowIdPrefix   = 'win-',
        theLoadingFrame  = null;

    /* Save the index configs */
    var indexUrl         = window.location.href;
    var indexTitle       = $('head > title').text();
    var indexTone        = '#145ccd';

    /* The default global settings */
    var defaults =
    {
        autoHideMenu                  : false,
        webRoot                       : '/',
        animateSpeed                  : 200,
        entryIconRoot                 : 'theme/default/images/ips/',
        windowHeadheight              : 30, // the height of window head bar
        bottomBarHeight               : 36, // the height of desk bottom bar
        defaultWinPosOffset           : 30,
        defaultWindowSize             : {width:700,height:538},
        windowidstrTemplate           : 'win-{0}',
        confirmClose                  : '确认要关闭　【{0}】 吗？',
        entryNotFindTip               : '应用没有找到！',
        busyTip                       : '应用正忙，请稍候...',
        reloadText                    : '刷新',
        closeText                     : '关闭',
        showWindowText                : '显示',
        confirmRemoveBlock            : '确定要移除区块 【{0}】 吗？',
        removedBlock                  : '区块已删除',
        orderdBlocksSaved             : '排序已保存',
        confirmCloseBrowser           : '提示：当前有打开的应用窗口',
        windowHtmlTemplate            : "<div id='{idstr}' class='window{cssclass}' style='width:{width}px;height:{height}px;left:{left}px;top:{top}px;z-index:{zindex};' data-id='{id}' data-url='{url}'><div class='window-head'>{iconhtml}<strong title='{desc}'>{name}</strong><ul><li><button class='reload-win'><i class='icon-repeat'></i></button></li><li><button class='min-win'><i class='icon-minus'></i></button></li><li><button class='max-win'><i class='icon-resize-full'></i></button></li><li><button class='close-win'><i class='icon-remove'></i></button></li></ul></div><div class='window-cover'></div><div class='window-content'></div></div>",
        frameHtmlTemplate             : "<iframe id='iframe-{id}' name='iframe-{id}' src='{url}' frameborder='no' allowtransparency='true' scrolling='auto' hidefocus='' style='width: 100%; height: 100%; left: 0px;'></iframe>",
        leftBarShortcutHtmlTemplate   : '<li id="s-menu-{id}"><button data-toggle="tooltip" data-placement="right" class="app-btn s-menu-btn" title="{name}" data-id="{id}">{iconhtml}</button></li>',
        taskBarShortcutHtmlTemplate   : '<li id="s-task-{id}"><button class="app-btn s-task-btn" title="{desc}" data-id="{id}">{iconhtml}{name}</button></li>',
        taskBarMenuHtmlTemplate       : "<ul class='dropdown-menu fade' id='taskMenu'><li><a href='###' class='reload-win'><i class='icon-repeat'></i> &nbsp;{reloadText}</a></li><li><a href='###' class='close-win'><i class='icon-remove'></i> &nbsp;{closeText}</a></li></ul>",
        entryListShortcutHtmlTemplate : '<li id="s-applist-{id}"><a href="javascript:;" class="app-btn" title="{desc}" data-id="{id}">{iconhtml}{name}</a></li>',

        init                          : function() // init the default
        {
            this.entryIconRoot = this.webRoot + this.entryIconRoot;
            this.taskBarMenuHtmlTemplate = this.taskBarMenuHtmlTemplate.format(this);
        }
    };

    /* Global setting */
    var settings = {};

    /* Initialize the settings
     *
     * @param  object options
     * @retrun void
     */
    function initSettings(options)
    {
        setTimeout(function(){indexTone = $('body').css('background-color')}, 2000);

        $.extend(settings, defaults, options);
        settings.init();
    }

    /*
     * Initialize the entries options
     *
     * @param  array entriesOptions
     * @return void
     */
    function initEntries(entriesOptions)
    {
        entriesConfigs = entriesOptions;
        entries        = [];


        for(var i in entriesConfigs)
        {
            entries.push(new entry(entriesConfigs[i]));
        }

        entries.sort(function(a, b){return a.order - b.order;});
    }

    function getEntry(id)
    {
        for(var i in entries)
        {
            var et = entries[i];
            if(id === et.id) return et;
        }
        return null;
    }

    /**
     * The entry object
     *
     * Create a entry object, example: 'var et = new entry({});'
     * A entry object stored the entry options and has a method to create a window object
     * 
     * @param object options
     */
    var entry = function(options)
    {
        this.init(options);
    }

    /* Get default options */
    entry.prototype.getDefaults = function(entryId)
    {
        var d =
        {
            url      : '',
            control  : 'simple',
            id       : entryId || windowIdTeamplate.format(windowIdSeed++),
            zindex   : windowZIndexSeed++,
            name     : 'No name entry',
            open     : 'iframe',
            desc     : '',
            order    : 0,
            display  : 'fixed',
            size     : 'max',
            position : 'default',
            icon     : '',
            cssclass : '',
            menu     : 'all' // wethear show in left menu bar
        };

        return d;
    };

    /* Reset the postion and size after initialized */
    entry.prototype.resetPosSize = function()
    {
        /* Init size setting */
        if(this.size == 'default')
        {
            this.width  = settings.defaultWindowSize.width;
            this.height = settings.defaultWindowSize.height;
        }
        else if(this.size.width != undefined && this.size.height != undefined)
        {
            this.width  = Math.min(this.size.width, desktop.width);
            this.height = Math.min(this.size.height, desktop.height);
        }
        else
        {
            this.width  = desktop.width;
            this.height = desktop.height;
            this.size = 'max';
            this.position  = {x: desktop.x, y: desktop.y};
            if(this.cssclass.indexOf(' window-max') < 0) this.cssclass += ' window-max';
        }

        /* Init position setting */
        if(this.position == 'center')
        {
            this.left = Math.max(desktop.x, desktop.x + (desktop.width - this.width)/2);
            this.top  = Math.max(desktop.y, desktop.y + (desktop.height - this.height)/2);
        }
        else if(this.position.x != undefined && this.position.y != undefined)
        {
            this.left = Math.max(desktop.x, this.position.x);
            this.top  = Math.max(desktop.y, this.position.y);
        }
        else
        {
            defaultWindowPos = {x: defaultWindowPos.x + settings.defaultWinPosOffset, y: defaultWindowPos.y + settings.defaultWinPosOffset};
            this.left = defaultWindowPos.x;
            this.top  = defaultWindowPos.y;
        }

        /* Determine the window whether be movable */
        if(this.display != 'fixed' && this.size != 'max' && this.cssclass.indexOf(' window-movable') < 0) this.cssclass += ' window-movable';
    };

    /* Recaculate the postion and size before create window */
    entry.prototype.reCalPosSize = function()
    {
        if(this.size.width != undefined && this.size.height != undefined)
        {
            this.width  = Math.min(this.size.width, desktop.width);
            this.height = Math.min(this.size.height, desktop.height);
        }
        else if(this.size == 'max')
        {
            this.width     = desktop.width;
            this.height    = desktop.height;
            this.position  = desktop.position;
        }

        if(this.position == 'center')
        {
            this.left = Math.max(desktop.x, desktop.x + (desktop.width - this.width)/2);
            this.top  = Math.max(desktop.y, desktop.y + (desktop.height - this.height)/2);
        }
    };

    /* Transform the entry to window html tags from template */
    entry.prototype.toWindowHtml = function()
    {
        this.reCalPosSize();
        return settings.windowHtmlTemplate.format(this);
    };

    /* Transform to shortcut html tag show in left bar from teamplte */
    entry.prototype.toLeftBarShortcutHtml = function()
    {
        if(this.menu) return settings.leftBarShortcutHtmlTemplate.format(this);
    };

    /* Transform to shortcut html tag show in task bar form template */
    entry.prototype.toTaskBarShortcutHtml = function()
    {
        if(this.display != 'modal') return settings.taskBarShortcutHtmlTemplate.format(this);
    };

    /* Transform to shortcut html tag in entry list form template */
    entry.prototype.toEntryListShortcutHtml = function()
    {
        return settings.entryListShortcutHtmlTemplate.format(this);
    };

    /* Create a window object */
    entry.prototype.createWindow = function()
    {
        if(this.display == 'modal') $('#modalContainer').append(this.toWindowHtml());
        else $('#deskContainer').append(this.toWindowHtml());
        $('#taskbar .bar-menu').append(this.toTaskBarShortcutHtml());
        $('.app-btn[data-id="'+this.id+'"]').addClass('open');

        return new windowx(this);
    };

    /* Initialize */
    entry.prototype.init = function(options)
    {
        if(!desktop)
        {
            var w = $(window);
            desktop = {x: desktopPos.x, y: desktopPos.y, width: w.width() - desktopPos.x, height: w.height() - desktopPos.y};
        }

        /* extend options from params */
        $.extend(this, this.getDefaults(options.id), options);

        this.idstr      = settings.windowidstrTemplate.format(this.id);
        this.cssclass   = '';

        /* you can use icon font name or an image url */
        if(this.icon.indexOf('icon-') == 0) this.iconhtml = '<i class="icon ' + this.icon + '"></i>';
        else if(this.icon.length > 0) this.iconhtml = '<img src="' + this.icon + '" alt="" />';
        else
        {
            var name = this.abbr || this.name;
            var nameL = name.length;
            this.iconhtml = '<i class="icon icon-default" style="background-color: hsl(' + (this.id*47%360) + ', 100%, 40%)"><span>' + (nameL > 0 ? name.slice(0, 1).toUpperCase() : '') + '</span><span class="text-extra">' + (nameL > 1 ? name.slice(1, 2).toUpperCase() : '') + '</span></i>';
        }

        /* mark modal with css class */
        if(this.display == 'modal')
        {
            this.cssclass += ' window-modal';
            this.zindex   += 50000;
            this.position  = 'center';
        }

        /* window open type */
        switch(this.open)
        {
            case 'iframe':
                this.cssclass += ' window-iframe';
                break;
            case 'json':
                this.cssclass += ' window-json';
                break;
        }

        /* init display setting */
        if(this.display == 'fixed' || this.display == 'modal')
        {
            this.cssclass += ' window-fixed';
        }

        /* init control bar setting */
        switch(this.control)
        {
            case '':
            case 'simple':
                this.cssclass += ' window-control-simple';
                break;
            case 'none':
                this.cssclass += ' window-control-none';
                break;
            case 'full':
                this.cssclass += ' window-control-full';
                break;
        }

        this.resetPosSize();
    };

    /**
     * The desktop Manager Object
     *
     * Manage the windows, menu, shortcuts and fullscreen apps
     */
    var desktopManager = function()
    {
        this.init();
        this.bindEvents();
    }

    /* Turn off the fullscreen mode */
    desktopManager.prototype.cancelFullscreenMode = function()
    {
        this.$.removeClass('fullscreen-mode');
        $('.fullscreen-active').removeClass('fullscreen-active');
        this.isFullscreenMode = false;
        $('.fullscreen-btn').each(function(){$(this).removeClass($(this).attr('data-toggle-class'))});
    }

    /* Turn on the fullscreen mode */
    desktopManager.prototype.turnOnFullscreenMode = function()
    {
        this.$.addClass('fullscreen-mode');
        this.isFullscreenMode = true;
        $('.fullscreen-active').removeClass('fullscreen-active');
        $('.fullscreen-btn, .app-btn').each(function(){$(this).removeClass($(this).attr('data-toggle-class')).removeClass('active')});
    }

    /* Turn on the modal mode */
    desktopManager.prototype.turnOnModalMode = function()
    {
        this.$.addClass('modal-mode');
    }

    desktopManager.prototype.toggleDropmenuMode = function(name, on)
    {
        this.$.toggleClass('dropdown-mode-' + name, on);
    }

    /* Determine wheather has entry window opened*/
    desktopManager.prototype.hasTask = function()
    {
        return $('#taskbar .bar-menu li').length > 0;
    }

    /* Initialize */
    desktopManager.prototype.init = function()
    {
        this.position  = desktopPos;
        this.x         = desktopPos.x;
        this.y         = desktopPos.y;

        this.$          = $('#desktop');
        this.$menu      = $('#apps-menu');
        this.$bottombar = $('#bottomBar');

        this.isFullscreenMode = this.$.hasClass('fullscreen-mode');
        
        this.menu           = new menu();
        this.shortcuts      = new shortcuts();
        this.startMenu      = new startMenu();
        this.fullScreenApps = new fullScreenApps();
        windows             = new windowsManager();

        this.updateBrowserUrl(indexUrl, true, 'index', {tag: 'index'});
    }

    /* Bind events */
    desktopManager.prototype.bindEvents = function()
    {
        $(window).resize($.proxy(function() // handle varables when window size changed
        {
            /* refresh desktop size */
            this.size   = {width: this.$.width() - this.x, height: this.$.height() - this.y - settings.bottomBarHeight};
            this.width  = this.size.width;
            this.height = this.size.height;

            /* refresh app menu size */
            var menu       = this.$menu;
            var iconHeight = menu.find('li').height();
            var menuHeight = this.height - this.$bottombar.height();
            if(iconHeight > 0)
            {
                while(menuHeight % iconHeight != 0)
                {
                    menuHeight--;
                }
            }
            menu.height(menuHeight);

            /* refresh entry window size */
            windows.afterBrowserResized();
            this.fullScreenApps.afterBrowserResized();
        }, this)).resize();

        $(document).on('click', '[data-toggle-class]', function()
        {
            var $e = $(this);
            var target = $e.attr('data-target');
            if(target != undefined) target = $(target); else target = $e;
            target.toggleClass($e.attr('data-toggle-class'));
            $e.toggleClass('toggle-on');
        });
    }

    /* Update browser url in address bar by change browser history */
    desktopManager.prototype.updateBrowserUrl = function(url, isForcePush, title, state)
    {
        url = url || indexUrl;
        state = state || {};
        try
        {
            if(isForcePush) window.history.pushState(state, title, url);
            else window.history.replaceState(state, title, url);
        }
        catch(e){}
    }

    /* Update browser title */
    desktopManager.prototype.updateBrowserTitle = function(title)
    {
        title = title || indexTitle;
        document.title = title;
    }

    /**
     * The Windows Manager Object
     *
     * Manage all windows displayed on desktop
     */
    var windowsManager = function()
    {

        this.init();
        this.bindEvents();
    }

    /* Initialize */
    windowsManager.prototype.init = function()
    {
        this.movingWindow     = null;
        this.activedWindow    = null;
        this.lastActiveWindow = null;
        this.set              = new Array();
    }

    /* Query window object, the query id can be window id or entry id */
    windowsManager.prototype.query = function(q)
    {
        return this.set[q] || this.set[settings.windowidstrTemplate.format(q)] || this.activedWindow;
    }

    /* Active a window with query id*/
    windowsManager.prototype.active = function(q)
    {
        var win = this.query(q);
        if(win == undefined) return;

        win.active();
    }

    /* Re-active the last actived window */
    windowsManager.prototype.activeLastWindow = function()
    {
        if(this.lastActiveWindow) this.lastActiveWindow.active();
    }

    /* Close a window */
    windowsManager.prototype.close = function(q)
    {
        var win = this.query(q);
        if(win == undefined) return;
        win.close();
        delete this.set[win.idstr];
    }

    /* Reload the actived window */
    windowsManager.prototype.reload = function()
    {
        if(this.activedWindow) this.activedWindow.reload();
    }

    /* Open a entry window */
    windowsManager.prototype.openEntry = function(et, url, go2index)
    {
        if(typeof et == 'string')
        {
            et = getEntry(et);
        }

        if(!et)
        {
            alert(settings.entryNotFindTip);
            return;
        }

        if(url && url.indexOf('javascript:') >=0 ) url = null;

        var win = this.set[et.idstr];

        if(!win)
        {
            if(et.open == 'blank')
            {
                window.open(et.url);
                return;
            }

            win = et.createWindow();
            this.set[et.idstr] = win;
            win.reload(url);
        }
        else if((go2index && !win.isIndex()) || (url != null && url != '' && url != win.url))
        {
            win.reload(url, go2index);
        }

        win.show();

        if(et.display != 'modal') desktop.cancelFullscreenMode();
        else desktop.turnOnModalMode();
    }

    /* Open a temporary entry window, entry options required */
    windowsManager.prototype.open = function(options)
    {
        var config = $.extend(
        {
            id      : windowIdTeamplate.format(windowIdSeed++),
            name    : '',
            open    : 'iframe',
            display : 'modal',
            size    : 'default',
            menu    : false,
            control : 'full'
        }, options);
        var et = new entry(config);
        this.openEntry(et);
    }

    /* Handle status before window active */
    windowsManager.prototype.beforeActive = function()
    {
        if(this.activedWindow)
        {
            if(this.activedWindow.isFullscreen())
            {
                this.activedWindow.hide(true);
            }
            else
            {
                this.lastActiveWindow = this.activedWindow;
            }

            this.activedWindow.$.removeClass('window-active').css('z-index', parseInt(this.activedWindow.$.css('z-index')) % 10000);
        }
    }

    /* Bind events */
    windowsManager.prototype.bindEvents = function()
    {
        $(document).on('click', '.window', function() // active by click a non actived window
        {
            windows.active($(this).attr('id'));
        }).on('mousedown', '.movable,.window-movable .window-head', function(e) // make the window movable with class '.movable' or '.window-movable'
        {
            var win = $(this).closest('.window:not(.window-max)');
            if(win.length < 1) return;

            windows.movingWindow = windows.set[win.attr('id')];

            var mwPos = win.position();
            win.data('mouseOffset', {x: e.pageX - mwPos.left, y: e.pageY - mwPos.top}).addClass('window-moving');
            $(document).bind('mousemove',mouseMove).bind('mouseup',mouseUp)
            e.preventDefault();

            function mouseUp()
            {
                $('.window.window-moving').removeClass('window-moving');
                windows.movingWindow = null;
                $(document).unbind('mousemove', mouseMove).unbind('mouseup', mouseUp)
            }

            function mouseMove(event)
            {
                if(windows.movingWindow && windows.movingWindow.hasClass('window-moving'))
                {
                    var offset = windows.movingWindow.$.data('mouseOffset');
                    windows.movingWindow.$.css(
                    {
                        left : event.pageX-offset.x,
                        top : event.pageY-offset.y
                    });
                }
            }
        }).keydown(this.handleWindowKeydown) // listen the keydown events
        .on('click', '.max-win', function(event) // max-win
        {
            windows.set[$(this).closest('.window').attr('id')].toggle();
            stopEvent(event);
        }).on('dblclick', '.window-head', function(event) // double click for max-win
        {
            windows.set[$(this).closest('.window').attr('id')].toggleSize();
            stopEvent(event);
        }).on('click', '.close-win', function(event) // close-win
        {
            var q = $(this).closest('.window').attr('data-id');
            if(!q) q = $(this).closest('.app-btn').attr('data-id');
            if(!q) q = $('#taskMenu.show').attr('data-id');
            windows.close(q);
        }).on('click', '.min-win', function(event) // min-win
        {
            windows.set[$(this).closest('.window').attr('id')].hide();
            stopEvent(event);
        }).on('click', '.reload-win', function(event) // reload window content
        {
            var q = $(this).closest('.window').attr('data-id');
            if(!q) q = $(this).closest('.app-btn').attr('data-id');
            if(!q) q = $('#taskMenu.show').attr('data-id');

            windows.query(q).reload();
        });

        try
        {
            window.addEventListener('popstate', function(e)
            {
                if (history.state)
                {
                    var state = e.state;
                }
            }, false);
        }
        catch(e){}
    }

    /* Handle window key down event */
    windowsManager.prototype.handleWindowKeydown = function(event)
    {
        if(event.keyCode == 116 || (event.ctrlKey && event.keyCode==82))
        {
            windows.reload();

            try{window.event.keyCode = 0;}catch(e){} // for IEs  
            try{window.frames[theLoadingFrame].event.keyCode = 0;}catch(e){} // for IEs  
            event.cancelBubble = true;
            event.returnValue  = false;
            event.preventDefault();
            event.stopPropagation();
            return false;
        }
    }

    /* Handle the status after browser size changed */
    windowsManager.prototype.afterBrowserResized = function()
    {
        for(var i in this.set)
        {
            this.set[i].afterResized();
        }
    }

    /**
     * The Window Object
     *
     * A window object to manage the window behavior and store the window status
     * Be deleted after closed
     *
     * @param object entry
     */
    var windowx = function(et)
    {
        this.init(et);
    }

    /* Initialize */
    windowx.prototype.init = function(et)
    {
        this.$ = $('#' + et.idstr);

        if(this.$.length < 1) throw new Error('Can not find the window: ' + et.idstr + ' when init it.');

        this.firstLoad = true;
        this.idstr     = this.$.attr('id');
        this.id        = this.$.attr('data-id');
        this.isModal   = this.$.hasClass('window-modal');
        this.entry     = et;
        this.indexUrl  = et.url;
        this.getUrl();

        this.afterResized(true);
    }

    /* Determine whether has the given class */
    windowx.prototype.hasClass = function(c)
    {
        return this.$.hasClass(c);
    }

    /* Determine whether the window is hiding(Mminimized) */
    windowx.prototype.isHide = function()
    {
        return this.hasClass('window-min');
    }

    /* Determine whether the window is loading content */
    windowx.prototype.isLoading = function()
    {
        return this.hasClass('window-loading');
    }

    /* Determine whether the window is fullscreen */
    windowx.prototype.isFullscreen = function()
    {
        return this.hasClass('window-fullscreen');
    }

    /* Determine whether the window is maximized */
    windowx.prototype.isMax = function()
    {
        return this.hasClass('window-max');
    }

    /* Determine whether the window is fixed size */
    windowx.prototype.isFixed = function()
    {
        return this.hasClass('window-fixed');
    }

    /* Determine whether the window is actived */
    windowx.prototype.isActive = function()
    {
        return this.hasClass('window-active');
    }

    /* Get the current content url */
    windowx.prototype.getUrl = function()
    {
        this.url = this.$.attr('data-url') || this.entry.url;
        return this.url;
    }

    windowx.prototype.getTitle = function()
    {
        this.title = this.title || this.$.attr('data-title') || this.entry.name;
        return this.title;
    }

    windowx.prototype.setTitle = function(title)
    {
        this.title = title || this.entry.name;
        this.$.attr('data-title', this.title);
    }

    windowx.prototype.setUrl = function(url)
    {
        this.url = url || this.indexUrl;
        this.$.attr('data-url', this.url);
    }

    windowx.prototype.isIndex = function()
    {
        return this.url == this.indexUrl;
    }

    /* Show or hide the window */
    windowx.prototype.toggle = function()
    {
        if(this.isHide()) this.show();
        else this.hide();
    }

    /* Hide the window by miximized */
    windowx.prototype.hide = function(silence)
    {
        if(!this.isHide())
        {
            this.$.fadeOut(settings.animateSpeed).addClass('window-min');
            if(!silence)
                windows.activeLastWindow();
        }
    }

    /* Show the window */
    windowx.prototype.show = function()
    {
        if(this.isHide())
        {
            this.$.fadeIn(settings.animateSpeed).removeClass('window-min');
        }
        this.active();
    }

    /* Reload the content */
    windowx.prototype.reload = function(url, go2index)
    {
        if(!this.isLoading())
        {
            if(go2index) this.setUrl();
            else if(url) this.setUrl(url);

            this.$.addClass('window-loading').removeClass('window-error').find('.reload-win i').addClass('icon-spin');

            if(this.firstLoad) this.$.addClass('window-first');

            switch(this.entry.open)
            {
                case 'iframe':
                    this.loadIframe(go2index);
                    break;
                case 'html':
                    this.loadHtml();
                    break;
            }

            if(!this.isActive()) this.active();
        }
        else
        {
            messager.warning(settings.busyTip);
        }
    }

    /* Load content with ajax */
    windowx.prototype.loadHtml = function()
    {
        var content = this.$.find('.window-content').html('');
        $.ajax(
        {
            url: this.getUrl(),
            dataType: 'html',
        })
        .done(function(data)
        {
            content.html(data);
        })
        .fail(function()
        {
            this.$.addClass('window-error');
        })
        .always(function()
        {
            this.$.removeClass('window-loading').removeClass('window-first');
            this.$.find('.reload-win i').removeClass('icon-spin');

            this.firstLoad = false;
        });
    }

    /* Load content with iframe */
    windowx.prototype.loadIframe = function(go2index)
    {
        var fName = 'iframe-' + this.id;
        theLoadingFrame = fName;
        var frame = document.getElementById(fName);
        var win = this;

        if(frame)
        {
            try
            {
                if(go2index) frame.contentWindow.location.replace(this.indexUrl);
                else frame.contentWindow.location.replace(this.getUrl());
            }
            catch(e)
            {
                document.getElementById(fName).src = (go2index ? this.indexUrl : this.getUrl());
            }
        }
        else
        {
            this.$.find('.window-content').html(settings.frameHtmlTemplate.format(this));
            frame = document.getElementById(fName);
        }

        frame.onload = frame.onreadystatechange = function()
        {
            if (this.readyState && this.readyState != 'complete') return;

            win.$.removeClass('window-loading').removeClass('window-first').find('.reload-win i').removeClass('icon-spin');

            try
            {
                var $frame = $(window.frames[fName].document);

                if($frame.length)
                {
                    var url = $frame.context.URL;
                    win.setUrl(url);
                    win.setTitle($frame.find('head > title').text());
                    if(win.entry) win.entry.currentUrl = url;

                    if(win.firstLoad)
                    {
                        win.indexUrl = url;
                        var colorTone = $frame.find('.navbar-inverse');
                        if(colorTone.length)
                        {
                            win.tone = colorTone.css('background-color');
                            $('body').css('background-color', win.tone);
                        }
                    }

                    $frame.unbind('keydown', windows.handleWindowKeydown).keydown(windows.handleWindowKeydown).data('data-id', win.idStr);
                }
            }
            catch(e){}

            win.updateEntryUrl(win.firstLoad);
            win.firstLoad = false;
        }
    }

    /* Update address bar when content url changed */
    windowx.prototype.updateEntryUrl = function(isForcePush)
    {
        desktop.updateBrowserUrl(this.url || this.indexUrl, isForcePush);
        desktop.updateBrowserTitle(this.getTitle());
    }

    /* Close the window */
    windowx.prototype.close = function()
    {
        var win = this.$;
        if(win.hasClass('window-safeclose') && (!confirm(settings.confirmClose.format(win.find('.window-head strong').text()))))
            return;

        /* save the last position and size */
        if(this.entry)
        {
            this.entry.left   = Math.max(desktopPos.x, win.position().left);
            this.entry.top    = Math.max(desktopPos.y, win.position().top);
            this.entry.width  = win.width();
            this.entry.height = win.height();
        }

        win.fadeOut(settings.animateSpeed, $.proxy(function()
        {
            $('.app-btn[data-id="' + this.id + '"]').removeClass('open').removeClass('active');
            $('#s-task-' + this.id).remove();
            win.remove();
            if(this.isModal) $('#desktop').removeClass('modal-mode');

            if(!desktop.hasTask() && !desktop.isFullscreenMode)
            {
                $('#showDesk').click();
                desktop.updateBrowserUrl();
                desktop.updateBrowserTitle();
            }
        }, this));

        $('.tooltip').remove();
        if(!this.isModal) windows.activeLastWindow();
    }

    /* Change the window status to maximized or normal */
    windowx.prototype.toggleSize = function()
    {
        var win = this.$;
        if(this.isFixed) return;

        if(this.isMax)
        {
            var orginLoc = win.data('orginLoc');
            win.removeClass('window-max').css(
            {
                left   : orginLoc.left,
                top    : orginLoc.top,
                width  : orginLoc.width,
                height : orginLoc.height
            }).find('.icon-resize-small').removeClass('icon-resize-small').addClass('icon-resize-full');
        }
        else
        {
            var dSize = desktop.size;
            win.data('orginLoc', 
            {
                left   : win.css('left'),
                top    : win.css('top'),
                width  : win.css('width'),
                height : win.css('height')
            }).addClass('window-max').css(
            {
                left   : desktop.position.x,
                top    : desktop.position.y,
                width  : dSize.width,
                height : dSize.height
            }).find('.icon-resize-full').removeClass('icon-resize-full').addClass('icon-resize-small');
        }
        this.afterResized(true);
    }

    /* Handle status after window size changed */
    windowx.prototype.afterResized = function(onlyAppSize)
    {
        if(!onlyAppSize)
        {
            if(this.isMax())
            {
                this.$.width(desktop.width)
                    .height(desktop.height)
                    .css(
                    {
                        left : desktop.x,
                        right: desktop.y
                    });
            }
        }

        var offset = this.$.hasClass('window-control-full') ? settings.windowHeadheight : 0;
        this.$.find('.window-content').height(this.$.height() - offset);
    }

    /* Active the window */
    windowx.prototype.active = function()
    {
        $('.app-btn.active, .fullscreen-btn.active').removeClass('active');
        $('.app-btn[data-id="' + this.id + '"]').addClass('active');
        $('body').css('background-color',this.tone ? this.tone : indexTone);

        if(this.isActive())
        {
            if(this.isHide())
            {
                this.show();
            }
            this.updateEntryUrl();
            return;
        }

        windows.beforeActive();
        this.$.addClass('window-active').css('z-index',parseInt(this.$.css('z-index')) + 10000);
        windows.activedWindow = this;
        
        this.updateEntryUrl();
    }

    /**
     * The start menu Object
     */
    var startMenu = function()
    {
        /* Initialize */
        this.init = function()
        {
            var menu = $('#startMenu');

            $(document).click(function()
            {
                menu.removeClass('in');
                setTimeout(function(){menu.removeClass('show');}, 100);
                desktop.toggleDropmenuMode('startmenu', false);
            });

            $('#start').click(function(e)
            {
                if(menu.hasClass('show'))
                {
                    menu.removeClass('in');
                    setTimeout(function(){menu.removeClass('show');}, 100);
                }
                else
                {
                    menu.addClass('show');
                    setTimeout(function(){menu.addClass('in')}, 0);
                }
                desktop.toggleDropmenuMode('startmenu', menu.hasClass('show'));
                e.stopPropagation();
            });
        }

        this.init();
    }

    /**
     * The fullscreen manager
     */
    function fullScreenApps()
    {
        /* Initialize */
        this.init = function()
        {
            this.$fullscreens = $('.fullscreen');

            this.handleAllApps();
            this.handleHomeBlocks();
        }

        /* Bind events */
        this.bindEvents = function()
        {
            $('.fullscreen-btn').click(function()
            {
                /* replace function 'show()' with 'toggle()' to change the behavoir */
                desktop.fullScreenApps.show($(this).attr('data-id'));
            });
        }

        /* Handle the app: all app list */
        this.handleAllApps = function()
        {
            $('#search').keyup(function(e)
            {
                if(e.which == 27) // pressed esc
                {
                    clearInput();
                }
                else if(e.which == 13) // pressed enter
                {
                    $('#allAppsList .app-btn.search-selected').click();
                }

                $('.search-selected').removeClass('search-selected');

                var val = $(this).val().toLowerCase();

                if(val.length > 0)
                {
                    var keys = val.split(' ');
                    var first = true;
                    $('#allAppsList .app-btn').each(function()
                    {
                        var btn = $(this);
                        var r = true, et = getEntry(btn.attr('data-id'));
                        for(var ki in keys)
                        {
                            var k = keys[ki];
                            r = r && (k=='' || (et.name.toLowerCase().indexOf(k) > -1) || (et.desc.toLowerCase().indexOf(k) > -1) || et.id.toLowerCase() == k);
                            if(!r) break;
                        }

                        btn.closest('li').toggleClass('search-hide', !r);

                        if(r && first)
                        {
                            first = false;
                            btn.addClass('search-selected');
                        }
                    });

                    $('#cancelSearch').fadeIn('fast');
                }
                else
                {
                    $('.search-hide').removeClass('search-hide');
                    $('#cancelSearch').fadeOut('fast');
                }
            });

            $('#cancelSearch').click(clearInput);

            function clearInput()
            {
                $('#search').val('').keyup();
            }
        }

        /* Handle the app: home blocks, use dashboard control in zui */
        this.handleHomeBlocks = function()
        {
            $('#home .dashboard').dashboard(
            {
                height            : 240,
                draggable         : true,
                afterOrdered      : afterOrdered,
                panelRemovingTip  : settings.confirmRemoveBlock,
                afterPanelRemoved : afterPanelRemoved
            });

            $('#home .dashboard .refresh-all-panel').click(function()
            {
                var $icon = $(this).find('.icon-repeat').addClass('icon-spin');
                $('#home .dashboard .refresh-panel').click();
                setTimeout(checkDone, 500);

                function checkDone()
                {
                    if($('#home .dashboard .panel-loading').length) setTimeout(checkDone, 500);
                    else $icon.removeClass('icon-spin');
                }
            });

            function afterPanelRemoved(index)
            {
                if(settings.onDeleteBlock && $.isFunction(settings.onDeleteBlock))
                {
                    settings.onDeleteBlock(index);
                    messager.info(settings.removedBlock);
                }
            }

            function afterOrdered(newOrders)
            {
                if(settings.onBlocksOrdered && $.isFunction(settings.onBlocksOrdered))
                {
                    settings.onBlocksOrdered(newOrders);
                }

                messager.success(settings.orderdBlocksSaved);
            }
        }

        /* Show a fullscreen app window */
        this.show = function(id)
        {
            desktop.turnOnFullscreenMode();

            $('#' + id).addClass('fullscreen-active');
            $('.fullscreen-btn[data-id="' + id + '"],.app-btn[data-id="' + id + '"]').addClass('active');
            desktop.updateBrowserUrl();
            desktop.updateBrowserTitle();

            if(id == 'allapps') $('#search').focus();

            $('body').css('background-color', indexTone);
        }

        /* Hide a fullscreen app window */
        this.hide = function(id)
        {
            $('.fullscreen-btn[data-id="' + id + '"],.app-btn[data-id="' + id + '"]').removeClass('active');
            desktop.cancelFullscreenMode();
            windows.active();
        }

        /* Show or hide a fullscreen app window */
        this.toggle = function(id)
        {
            if($('#' + id).hasClass('fullscreen-active')) this.hide(id);
            else this.show(id);
        }

        /* Handle status after browser size changed */
        this.afterBrowserResized = function()
        {
            this.$fullscreens.width(desktop.width).height(desktop.height).css({left: desktop.x, top: desktop.y});;
        }

        this.init();
        this.bindEvents();
    }

    /**
     * Manage the shortcuts
     */
    function shortcuts()
    {
        /* Initialize */
        this.init = function()
        {
            this.$leftBar     = $('#leftBar');
            this.$taskBar     = $('#taskbar');
            this.$appsMenu    = $('#apps-menu .bar-menu');
            this.$allAppsList = $("#allAppsList .bar-menu");

            this.showAll();
            this.bindEvents();
        }

        /* Show all shortcuts */
        this.showAll = function()
        {
            for(var index in entries)
            {
                this.show(entries[index]);
            }
        }

        /* show a shortcut */
        this.show = function(entry)
        {
            if(entry.menu == 'menu' || entry.menu == 'all') this.$appsMenu.append(entry.toLeftBarShortcutHtml());
            if(entry.menu == 'all' || entry.menu == 'list') this.$allAppsList.append(entry.toEntryListShortcutHtml());
        }

        /* Bind events */
        this.bindEvents = function()
        {
            $(document).on('click', '.window-btn', function(event)
            {
                var btn = $(this);
                windows.open(
                {
                    url : btn.attr('href') || btn.attr('data-url'),
                    open: btn.attr('data-open') || 'iframe', 
                    icon: btn.attr('data-icon'), 
                    name: btn.attr('data-name')
                });
                stopEvent(event);
                return false;
            }).on('click', '.app-btn', function(event)
            {
                var $this = $(this);
                var et = getEntry($this.attr('data-id'));
                if(et)
                {
                    if(et.display == 'fullscreen' && desktop.fullScreenApps) desktop.fullScreenApps.toggle(et.id);
                    else windows.openEntry(et, $this.attr('href') || $this.data('url'));
                }
                else
                {
                    alert(settings.entryNotFindTip);
                }

                event.preventDefault();
                if(et.id != 'superadmin')
                {
                    event.stopPropagation();
                    return false;
                }
            });

            this.$leftBar.bind('contextmenu', nocontextmenu);
            this.$taskBar.bind('contextmenu', nocontextmenu);

            $(document).on('mousedown', '.app-btn.open', function(e)
            {
                if(e.which == 3)
                {
                    var btn = $(this),menu = $('#taskMenu'), offset = btn.offset();
                    if(!menu.length) menu = $(settings.taskBarMenuHtmlTemplate).appendTo('#desktop');
                    if(menu.hasClass('show'))
                    {
                        menu.removeClass('in');
                        setTimeout(function(){menu.removeClass('show');}, 100);
                    }
                    else
                    {
                        menu.addClass('show');
                        setTimeout(function(){menu.addClass('in')}, 0);
                    }
                    // menu.toggleClass('show');
                    desktop.toggleDropmenuMode('taskmenu', menu.hasClass('show'));

                    if(menu.hasClass('show'))
                    {
                        menu.attr('data-id', btn.attr('data-id'));
                        if(btn.hasClass('s-menu-btn'))
                        {
                            menu.css({left: desktopPos.x + 2, top: offset.top, bottom: 'inherit'});
                            $('.tooltip').remove();
                        }
                        else if(btn.hasClass('s-task-btn')) menu.css({left: offset.left, top: 'inherit', bottom: settings.bottomBarHeight + 2});
                    }
                }
            });

            $(document).click(function(e)
            {
                if($(e.target).hasClass('app-btn')) return false;
                var menu = $('#taskMenu');
                menu.removeClass('in');
                setTimeout(function(){menu.removeClass('show');}, 100);
                desktop.toggleDropmenuMode('taskmenu', false);
            });

            function nocontextmenu(event)
            {
                event.cancelBubble = true
                event.returnValue = false;

                return false;
            }

            function norightclick(e) 
            {
                if (window.Event) 
                {
                    if (e.which == 2 || e.which == 3)
                    return false;
                }
                else if (event.button == 2 || event.button == 3)
                {
                    event.cancelBubble = true
                    event.returnValue  = false;
                    return false;
                }
            }
        }

        this.init();
    }

    /**
     * The menu object
     */
    function menu()
    {
        /* Initialize */
        this.init = function()
        {
            this.$leftBar = $('#leftBar');

            if(settings.autoHideMenu)
            {
                this.$leftBar.addClass('menu-auto');
                desktop.position.x = 2;
                setTimeout(this.hide, 2000);

                this.$leftBar.addClass('menu-auto').mouseover(this.show).mouseout(this.hide);;
            }
        }

        /* Hide the menu */
        this.hide = function()
        {
            var $leftBar = desktop.menu.$leftBar;
            $leftBar.removeClass('menu-show');
            setTimeout(function()
            {
                if(!$leftBar.hasClass('menu-show'))
                {
                    $leftBar.addClass('menu-hide');
                    $('#apps-menu .app-btn[data-toggle="tooltip"]').removeAttr('data-toggle');
                }
            }, 1000);
        }

        /* Show the menu */
        this.show = function()
        {
            desktop.menu.$leftBar.removeClass('menu-hide').addClass('menu-show');
            setTimeout(function(){$('#apps-menu .app-btn').attr('data-toggle', 'tooltip');}, 500);
        }

        this.init();
    }

    /**
     * Stop propagation and prevent default behaviors
     */
    function stopEvent(event)
    {
        event.preventDefault();
        event.stopPropagation();
    }

    /* Open an entry by given id and url */
    function openEntry(id, url)
    {
        windows.openEntry(id, url);
    }

    /* 
     * Start ips
     *
     * @param  array  entiresOptions
     * @param  object options
     * @return void
     */
    function start(entriesOptions, options)
    {
        initSettings(options);
        initEntries(entriesOptions);

        desktop = new desktopManager();

        var entryId = getQueryString('entryId');
        if(entryId)
        {
            openEntry(entryId, getQueryString('entryUrl'));
        }
    }

    /*
     * Close modal window opened in desktop
     *
     * @return void
     */
    function closeModal()
    {
        windows.close($('#modalContainer .window').attr('id'));
    }

    /**
     * Get query string value
     * 
     * @access public
     * @return string
     */
    function getQueryString(name)
    {
        var reg = new RegExp("(^|&)" + name + "=([^&]*)(&|$)", "i");
        var r = window.location.search.substr(1).match(reg);
        if (r != null) return unescape(r[2]); return null;
    }

    /* make jquery object call the ips interface manager */
    $.extend({ipsStart: start, closeModal: closeModal, openEntry: openEntry, getQueryString: getQueryString});
}(jQuery, window, document, Math);
