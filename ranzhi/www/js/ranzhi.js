/**
 * force load entry content with iframe when view entry
 * 
 * @access public
 * @return void
 */
(function()
{
    var redirect = function()
    {
        if(config && config.currentModule != 'index' && !(config.currentModule == 'user' && config.appName == 'sys') && config.currentModule != 'entry' && (!self.frameElement || self.frameElement.tagName != 'IFRAME') && typeof v != 'undefined' && typeof v.entryID != 'undefined' && v.entryID != '') window.location.href = '/sys/index.php?entryID=' + v.entryID + '&entryUrl=' + window.location.pathname;
    };

    redirect();
    $(redirect);
}());

$.extend(
{
    setAjaxForm: function(formID, callback)
    {
        if($(document).data('setAjaxForm:' + formID)) return;

        form = $(formID);

        var options = 
        {
            target  : null,
            timeout : 30000,
            dataType:'json',
            
            success: function(response)
            {
                $.enableForm(formID);
                var submitButton = $(formID).find(':input[type=submit], .submit');

                /* The response is not an object, some error occers, bootbox.alert it. */
                if($.type(response) != 'object')
                {
                    if(response) return bootbox.alert(response);
                    return bootbox.alert('No response.');
                }

                /* The response.result is success. */
                if(response.result == 'success')
                {
                    if(response.message && response.message.length)
                    {
                        submitButton.popover({trigger:'manual', content:response.message, placement:'right'}).popover('show');
                        submitButton.next('.popover').addClass('popover-success');
                        function distroy(){submitButton.popover('destroy')}
                        setTimeout(distroy,2000);
                    }

                    if($.isFunction(callback)) return callback(response);

                    if($('#responser').length && response.message && response.message.length)
                    {
                        $('#responser').html(response.message).addClass('red f-12px').show().delay(3000).fadeOut(100);
                    }

                    if(response.locate) 
                    {
                        if(response.locate == 'reload') return setTimeout(function(){location.href = location.href;}, 1200);
                        return setTimeout(function(){location.href = response.locate;}, 1200);
                    }

                    return true;
                }

                /**
                 * The response.result is fail. 
                 */

                /* The result.message is just a string. */
                if($.type(response.message) == 'string')
                {
                    if($('#responser').length == 0)
                    {
                        submitButton.popover({trigger:'manual', content:response.message, placement:'right'}).popover('show');
                        submitButton.next('.popover').addClass('popover-danger');
                        function distroy(){submitButton.popover('destroy')}
                        setTimeout(distroy,2000);
                    }
                    $('#responser').html(response.message).addClass('red f-12px').show().delay(5000).fadeOut(100);
                }

                /* The result.message is just a object. */
                if($.type(response.message) == 'object')
                {
                    $.each(response.message, function(key, value)
                    {
                        /* Define the id of the error objecjt and it's label. */
                        var errorOBJ   = '#' + key;
                        var errorLabel =  key + 'Label';

                        /* Create the error message. */
                        var errorMSG = '<span id="'  + errorLabel + '" for="' + key  + '"  class="text-error red">';
                        errorMSG += $.type(value) == 'string' ? value : value.join(';');
                        errorMSG += '</span>';

                        /* Append error message, set style and set the focus events. */
                        $('#' + errorLabel).remove(); 
                        var $errorOBJ = $(errorOBJ);
                        if($errorOBJ.closest('.input-group').length > 0)
                        {
                            $errorOBJ.closest('.input-group').after(errorMSG)
                        }
                        else
                        {
                            $errorOBJ.parent().append(errorMSG);
                        }
                        $errorOBJ.css('margin-bottom', 0);
                        $errorOBJ.css('border-color','#953B39')
                        $errorOBJ.change(function()
                        {
                            $errorOBJ.css('margin-bottom', 0);
                            $errorOBJ.css('border-color','')
                            $('#' + errorLabel).remove(); 
                        });
                    })

                    /* Focus the first error field thus to nitify the user. */
                    var firstErrorField = $('#' +$('span.red').first().attr('for'));
                    if(firstErrorField.length) topOffset = parseInt(firstErrorField.offset().top) - 20;   // 20px offset more for margin.

                    /* If there's the navbar-fixed-top element, minus it's height. */
                    if($('.navbar-fixed-top').size())
                    {
                        topOffset = topOffset - parseInt($('.navbar-fixed-top').height());
                    }
                    
                    /* Scroll to the error field and foucus it. */
                    $(document).scrollTop(topOffset);
                    firstErrorField.focus();
                }

                if($.isFunction(callback)) return callback(response);
            },

            /* When error occers, alert the response text, status and error. */
            error: function(jqXHR, textStatus, errorThrown)
            {
                $.enableForm(formID);
                if(textStatus == 'timeout')
                {
                    bootbox.alert(v.lang.timeout);
                    return false;
                }
                bootbox.alert(jqXHR.responseText + textStatus + errorThrown);
            }
        };

        /* Call ajaxSubmit to sumit the form. */
        $(document).on('submit', formID, function()
        { 
            $.disableForm(formID);
            $(this).ajaxSubmit(options);
            return false;    // Prevent the submitting event of the browser.
        }).data('setAjaxForm:' + formID, true);
    },

    /* Switch the label and disabled attribute for the submit button in a form. */
    setSubmitButton: function(formID, action)
    {
        var submitButton = $(formID).find(':submit');

        label    = submitButton.val();
        loading  = submitButton.data('loading');
        disabled = action == 'disable';

        submitButton.attr('disabled', disabled);
        submitButton.val(loading);
        submitButton.data('loading', label);
    },

    /* Disable a form. */
    disableForm: function(formID)
    {
        $.setSubmitButton(formID, 'disable');
    },
    
    /* Enable a form. */
    enableForm: function(formID)
    {
        $.setSubmitButton(formID, 'enable');
    }
});

$.extend(
{
    /**
     * Set ajax loader.
     * 
     * Bind click event for some elements thus when click them, 
     * use $.load to load page into target.
     *
     * @param string selector
     * @param string target
     */
    setAjaxLoader: function(selector, target)
    {
        $(document).on('click', selector, function()
        {
            url = $(this).attr('href');
            if(!url) url = $(this).data('rel');
            if(!url) return false;

            var $target = $(target);
            if(!$target.size()) return false;
            $target.load(url, function()
            {
                if($target.hasClass('modal') && $.ajustModalPosition) $.ajustModalPosition();
            });

            return false;
        });
    },

    /**
     * Set ajax jsoner.
     *
     * @param string   selector
     * @param object   callback
     */
    setAjaxJSONER: function(selector, callback)
    {
        $(document).on('click', selector, function()
        {
            /* Try to get the href of current element, then try it's data-rel attribute. */
            url = $(this).attr('href');
            if(!url) url = $(this).data('rel');
            if(!url) return false;
            
            $.getJSON(url, function(response)
            {
                /* If set callback, call it. */
                if($.isFunction(callback)) return callback(response);

                /* If the response has message attribute, show it in #responser or alert it. */
                if(response.message)
                {
                    if($('#responser').length)
                    {
                        $('#responser').html(response.message);
                        $('#responser').addClass('text-info f-12px');
                        $('#responser').show().delay(3000).fadeOut(100);
                    }
                    else
                    {
                        bootbox.alert(response.message);
                    }
                }

                /* If the response has locate param, locate the browse. */
                if(response.locate) return location.href = response.locate;

                /* If target and source returned in reponse, update target with the source. */
                if(response.target && response.source)
                {
                    $(response.target).load(response.source);
                }
            });

            return false;
        });
    },

    /**
     * Set ajax deleter.
     * 
     * @param  string $selector 
     * @access public
     * @return void
     */
    setAjaxDeleter: function (selector)
    {
        $(document).on('click', selector, function()
        {
            if(confirm(v.lang.confirmDelete))
            {
                var deleter = $(this);
                deleter.text(v.lang.deleteing);

                $.getJSON(deleter.attr('href'), function(data) 
                {
                    if(data.result == 'success')
                    {
                        if(deleter.parents('#ajaxModal').size()) return $.reloadAjaxModal(1200);
                        if(data.locate) return location.href = data.locate;
                        return location.reload();
                    }
                    else
                    {
                        alert(data.message);
                    }
                });
            }
            return false;
        });
    },

    /**
     * Set reload deleter.
     * 
     * @param  string $selector 
     * @access public
     * @return void
     */
    setReloadDeleter: function (selector)
    {
        $(document).on('click', selector, function()
        {
            if(confirm(v.lang.confirmDelete))
            {
                var deleter = $(this);
                deleter.text(v.lang.deleteing);

                $.getJSON(deleter.attr('href'), function(data) 
                {
                    if($.isFunction(deleter.data('afterDelete')))
                    {
                        $.proxy(deleter.data('afterDelete'), deleter)(data);
                    }

                    if(data.result == 'success')
                    {


                        var table     = $(deleter).closest('table');
                        var replaceID = table.attr('id');

                        table.wrap("<div id='tmpDiv'></div>");
                        $('#tmpDiv').load(document.location.href + ' #' + replaceID, function()
                        {   
                            $('#tmpDiv').replaceWith($('#tmpDiv').html());
                            if(typeof sortTable == 'function')
                            {   
                                sortTable(); 
                            }   
                            else
                            {   
                                $('tfoot td').css('background', 'white').unbind('click').unbind('hover');
                            }   
                        });
                    }
                    else
                    {
                        alert(data.message);
                    }
                });
            }
            return false;
        });
    },

    /**
     * Set reload.
     * 
     * @param  string $selector 
     * @access public
     * @return void
     */
    setReload: function (selector)
    {
        $(document).on('click', selector, function()
        {
            var reload = $(this);
            $.getJSON(reload.attr('href'), function(data) 
            {
                if(data.result == 'success')
                {
                    var table     = $(reload).closest('table');
                    var replaceID = table.attr('id');

                    table.wrap("<div id='tmpDiv'></div>");
                    $('#tmpDiv').load(document.location.href + ' #' + replaceID, function()
                    {   
                        $('#tmpDiv').replaceWith($('#tmpDiv').html());
                        if(typeof sortTable == 'function')
                        {   
                            sortTable(); 
                        }   
                        else
                        {   
                            $('tfoot td').css('background', 'white').unbind('click').unbind('hover');
                        }   
                    });
                }
                else
                {
                    alert(data.message);
                }
            });
            return false;
        });
    },

    /**
     * Add ajaxModal container if there's an <a> tag with data-toggle=modal.
     * 
     * @access public
     * @return void
     */
    setAjaxModal: function()
    {
        if($('a[data-toggle=modal]').size() == 0) return false;

        /* Addpend modal div. */
        $('<div id="ajaxModal" class="modal fade"></div>').appendTo('body');

        /* Set the data target for modal. */
        $('a[data-toggle=modal]').attr('data-target', '#ajaxModal');

        $(document).on('click', 'a[data-toggle=modal]', function()
        {
            var $e = $(this);
            $('#ajaxModal').load($e.attr('href'),function()
            {
                /* Set the width of modal dialog. */
                if($e.data('width'))
                {
                    var modalWidth = parseInt($e.data('width'));
                    $(this).data('width', modalWidth).find('.modal-dialog').css('width', modalWidth);
                }
            });

            /* Save the href to rel attribute thus we can save it. */
            $('#ajaxModal').attr('rel', $(this).attr('href'));
        });
    },

    /**
     * Set modal load content with ajax or iframe
     * 
     * @access public
     * @return void
     */
    setModal: function()
    {
        jQuery.fn.modalTrigger = function(setting)
        {
            $(this).click(function(event)
            {
                var $e   = $(this);
                if($e.closest('.body-modal').length) return;

                if($e.hasClass('disabled')) return false;

                var url  = (setting ? setting.url : false) || $e.attr('href') || $e.data('url');
                var type = (setting ? setting.type : false) || $e.hasClass('iframe') ? 'iframe' : ($e.data('type') || 'ajax');
                var options = 
                {
                    url:        url,
                    width:      $e.data('width') || null,
                    height:     $e.data('height') || 'auto',
                    icon:       $e.data('icon') || '?',
                    title:      $e.data('title') || $e.attr('title') || $e.text(),
                    name:       $e.data('name') || 'modalIframe',
                    cssClass:   $e.data('class'),
                    headerless: $e.data('headerless') || false,
                    center:     $e.data('center') || true
                };

                if(options.icon == '?')
                {
                    var i = $e.find("[class^='icon-']");
                    options.icon = i.length ? i.attr('class').substring(5) : 'file-text';
                }

                options = $.extend(options, setting);

                if(type == 'iframe')
                {
                    showIframeModal(options);
                }
                else
                {
                    initModalFrame(options);
                    var modal = $('#ajaxModal').addClass('modal-loading').modal('show');
                    modal.load(options.url, function()
                    {
                        setTimeout(function()
                        {
                            var modalBody = modal.find('.modal-body'), dialog = modal.find('.modal-dialog');
                            if(options.height != 'auto') modalBody.css('height', options.height);
                            if(options.width) dialog.css('width', options.width);
                            if(options.center) ajustModalPosition();
                            modal.removeClass('modal-loading');
                        },200);
                    });
                }

                /* Save the href to rel attribute thus we can save it. */
                $('#ajaxModal').attr('rel', options.url);

                return false;
            });
        }

        function showIframeModal(settings)
        {
            var options = 
            {
                width:      null,
                height:     'auto',
                icon:       '?',
                title:      '',
                name:       'modalIframe',
                cssClass:   '',
                headerless: false,
                waittime:   0,
                center:     true
            }
            
            if(typeof(settings) == 'string')
            {
                options.url = settings;
            }
            else
            {
                options = $.extend(options, settings);
            }

            initModalFrame(options);

            if(isNum(options.height.toString())) options.height += 'px';
            if(isNum(options.width.toString())) options.width += 'px';
            if(options.size == 'fullscreen')
            {
                var $w = $(window);
                options.width = $w.width();
                options.height = $w.height();
                options.cssClass += ' fullscreen';
            }
            if(options.headerless)
            {
                options.cssClass += ' hide-header';
            }

            var modal = $('#ajaxModal').addClass('modal-loading').data('first', true);

            modal.html("<div class='icon-spinner icon-spin loader'></div><div class='modal-dialog modal-iframe' style='width: {width};'><div class='modal-content'><div class='modal-header'><button class='close' data-dismiss='modal'>×</button><h4 class='modal-title'><i class='icon-{icon}'></i> {title}</h4></div><div class='modal-body' style='height:{height}'><iframe id='{name}' name='{name}' src='{url}' frameborder='no' allowtransparency='true' scrolling='auto' hidefocus='' style='width: 100%; height: 100%; left: 0px;'></iframe></div></div></div>".format(options));

            var modalBody = modal.find('.modal-body'), dialog = modal.find('.modal-dialog');
            if(options.cssClass)
            {
                dialog.addClass(options.cssClass);
            }

            if(options.waittime > 0)
            {
                options.waitingFuc = setTimeout(function(){showModal(options, modal, modalBody, dialog);}, options.waittime );
            }

            var frame = document.getElementById(options.name);
            frame.onload = frame.onreadystatechange = function()
            {

                if(this.readyState && this.readyState != 'complete') return;
                if(!modal.hasClass('modal-loading')) return;
                if(!modal.data('first')) modal.addClass('modal-loading');

                if(options.waittime > 0)
                {
                    clearTimeout(options.waitingFuc);
                }
                showModal(options, modal, modalBody, dialog);
            }
            modal.modal('show');
        }

        function showModal(options, modal, modalBody, dialog)
        {
            modalBody.css('height', options.height - modal.find('.modal-header').outerHeight());
            try
            {
                var $frame = $(window.frames[options.name].document);
                if($frame.find('#titlebar').length)
                {
                    modal.addClass('with-titlebar');
                    if(options.size == 'fullscreen')
                    {
                        modalBody.css('height', options.height);
                    }
                }
                if(options.height == 'auto')
                {
                    var $framebody = $frame.find('body');
                    setTimeout(function()
                    {
                        var fbH = $framebody.addClass('body-modal').outerHeight();
                        if(typeof fbH == 'object') fbH = $framebody.height();
                        modalBody.css('height', fbH);
                        if(options.center) ajustModalPosition();
                        modal.removeClass('modal-loading');
                        if(modal.data('first')) modal.data('first', false);
                    }, 100);

                    if(navigator.userAgent.indexOf("MSIE 8.0") < 0)
                    {
                        $framebody.resize(function()
                        {
                            var fbH = $framebody.addClass('body-modal').outerHeight();
                            if(typeof fbH == 'object') fbH = $framebody.height();
                            modalBody.css('height', fbH);
                        });
                    }
                }
                else
                {
                    modal.removeClass('modal-loading');
                }

                var iframe$ = window.frames[options.name].$;
                if(iframe$)
                {
                    iframe$.extend({'closeModal': $.closeModal});
                }
            }
            catch(e)
            {
                modal.removeClass('modal-loading');
            }
        }

        function initModalFrame(setting)
        {
            if($('#ajaxModal').length)
            {
                /* unbind all events */
                $('#ajaxModal').off('show.bs.modal shown.bs.modal hide.bs.modal hidden.bs.modal escaping.bs.modal');
            }
            else
            {
                /* Addpend modal div. */
                $('<div id="ajaxModal" class="modal fade"></div>').appendTo('body');
            }

            $ajaxModal = $('#ajaxModal');
            $ajaxModal.data('cancel-reload', false);

            $.extend({'closeModal':function(callback, location)
            {
                $ajaxModal.modal('hide');
                $ajaxModal.on('hidden.bs.modal', function()
                {
                    if(location && (!$ajaxModal.data('cancel-reload')))
                    {
                        if(location == 'this') window.location.reload();
                        else window.location = location;
                    }
                    if(callback && $.isFunction(callback)) callback();
                });
            }, 'cancelReloadCloseModal': function(){$ajaxModal.data('cancel-reload', true);}});

            /* rebind events */
            if(setting)
            {
                if(setting.afterShow && $.isFunction(setting.afterShow)) $ajaxModal.on('show.bs.modal', setting.afterShow);
                if(setting.afterShown && $.isFunction(setting.afterShown)) $ajaxModal.on('shown.bs.modal', setting.afterShown);
                if(setting.afterHide && $.isFunction(setting.afterHide)) $ajaxModal.on('hide.bs.modal', setting.afterHide);
                if(setting.afterHidden && $.isFunction(setting.afterHidden)) $ajaxModal.on('hidden.bs.modal', setting.afterHidden);
            }
            
            /* check form changes when close modal */
            $ajaxModal.on('shown.bs.modal', function()
            {
                $(document).on('keyup.modal.changes paste.modal.changes', '#ajaxModal form input, #ajaxModal form textarea', function()
                {
                    $(this).addClass('modal-val-changed');
                });
            }).on('escaping.bs.modal', function(event, esc)
            {
                if($('#ajaxModal form .modal-val-changed').length)
                {
                    return confirm(v.lang.confirmDiscardChanges);
                }
            }).on('hidden.bs.modal', function(){$(document).off('keyup.modal.changes paste.modal.changes');});
        }

        function ajustModalPosition(position)
        {
            position = position || 'fit';
            var dialog = $('#ajaxModal .modal-dialog');
            if(position)
            {
               var half = Math.max(0, ($(window).height() - dialog.outerHeight())/2);
               var pos = position == 'fit' ? (half*2/3) : (position == 'center' ? half : position);
               dialog.css('margin-top', pos);
            }
        }

        $.extend({modalTrigger: showIframeModal, ajustModalPosition: ajustModalPosition});

        $('[data-toggle=modal], a.iframe').modalTrigger();
    },


    /**
     * Reload ajax modal.
     *
     * @param int duration 
     * @access public
     * @return void
     */
    reloadAjaxModal: function(duration)
    {
        if(typeof(duration) == 'undefined') duration = 1000;
        setTimeout(function()
        {
            var modal = $('#ajaxModal');
            modal.load(modal.attr('rel'), function(){$(this).find('.modal-dialog').css('width', $(this).data('width')); $.ajustModalPosition()})}, duration);
    }
});

/**
 * Judge the string is a integer number
 * 
 * @access public
 * @return bool
 */
function isNum(s)
{
    if(s!=null)
    {
        var r, re;
        re = /\d*/i;
        r = s.match(re);
        return (r == s) ? true : false;
    }
    return false;
}

/**
 * Create link. 
 * 
 * @param  string $moduleName 
 * @param  string $methodName 
 * @param  string $vars 
 * @param  string $viewType 
 * @access public
 * @return string
 */
function createLink(moduleName, methodName, vars, viewType)
{
    if(!viewType) viewType = config.defaultView;
    if(vars)
    {
        vars = vars.split('&');
        for(i = 0; i < vars.length; i ++) vars[i] = vars[i].split('=');
    }
    if(config.requestType == 'PATH_INFO')
    {
        link = config.webRoot + config.appName + '/' + moduleName + config.requestFix + methodName;
        if(vars)
        {
            if(config.pathType == "full")
            {
                for(i = 0; i < vars.length; i ++) link += config.requestFix + vars[i][0] + config.requestFix + vars[i][1];
            }
            else
            {
                for(i = 0; i < vars.length; i ++) link += config.requestFix + vars[i][1];
            }
        }
        link += '.' + viewType;
    }
    else
    {
        link = config.router + '?' + config.moduleVar + '=' + moduleName + '&' + config.methodVar + '=' + methodName + '&' + config.viewVar + '=' + viewType;
        if(vars) for(i = 0; i < vars.length; i ++) link += '&' + vars[i][0] + '=' + vars[i][1];
    }
    return link;
}

/**
 * Set required fields, add star class to them.
 *
 * @access public
 * @return void
 */
function setRequiredFields()
{
    if(!config.requiredFields) return false;
    requiredFields = config.requiredFields.split(',');
    for(i = 0; i < requiredFields.length; i++)
    {
        $('#' + requiredFields[i]).closest('td,th').prepend("<div class='required required-wrapper'></div>");
        var colEle = $('#' + requiredFields[i]).closest('[class*="col-"]');
        if(colEle.parent().hasClass('form-group')) colEle.addClass('required');
    }
}

/**
 * Set language.
 * 
 * @access public
 * @return void
 */
function selectLang(lang)
{
    $.cookie('lang', lang, {expires:config.cookieLife, path:config.webRoot});
    location.href = removeAnchor(location.href);
}

/**
 * Remove anchor from the url.
 * 
 * @param  string $url 
 * @access public
 * @return string
 */
function removeAnchor(url)
{
    pos = url.indexOf('#');
    if(pos > 0) return url.substring(0, pos);
    return url;
}

/**
 * Ping to keep login 
 * 
 * @access public
 * @return void
 */
function ping()
{
    $.get(createLink('misc', 'ping'));
}

/**
 * Select lang.
 * 
 * @param  string $lang 
 * @access public
 * @return void
 */
function selectLang(lang)                                                                                                
{                                                                                                                        
    $.cookie('lang', lang, {expires:config.cookieLife, path:config.webRoot});                                            
    location.href = removeAnchor(location.href);                                                                         
}                                                                                                                        

/**
 * Fix table header in admin page
 * 
 * @access public
 * @return void
 */
function fixTableHeader()
{
    var table = $('.page-content > .panel > .table');

    if(!table.length) return;

    var tHead     = table.find('thead');
    var navHeight = $('#mainNavbar').outerHeight();
    var gap       = tHead.offset().top - $('#mainNavbar').outerHeight();
    var col       = table.closest('.page-content');

    $(window).scroll(function()
    {
        var fixedHeader = $('#fixedHeader');
        if(!fixedHeader.length)
        {
            fixedHeader = $('<table class="table" id="fixedHeader"></table>').attr('class', table.attr('class')).append(tHead.clone()).appendTo(col);
            resizeHeader();
        }

        if($(window).scrollTop() > gap)
        {
            col.addClass('with-fixed-table');
            // fixedHeader.fadeIn();
        }
        else
        {
            col.removeClass('with-fixed-table');
            // fixedHeader.fadeOut();
        }
    }).resize(resizeHeader);

    function resizeHeader()
    {
        var headers  = $('#fixedHeader thead th');
        var tHeaders = tHead.find('th');

        for (var i = headers.length - 1; i >= 0; i--)
        {
            $(headers[i]).width($(tHeaders[i]).width());
        };

        $('#fixedHeader').css({top: navHeight, left: tHead.offset().left, width: table.width()});
    }
}

/**
 * Make form condensed
 * 
 * @access public
 * @return void
 */
function condensedForm()
{
    $('.form-condensed legend').click(function()
    {
        $(this).closest('fieldset').toggleClass('collapsed');
    });
}

/**
 * Set page actions
 * 
 * @access public
 * @return void
 */
function setPageActions()
{
    var bar = $('.page-actions'), barTop, barWidth;
    if(bar.length)
    {
        barTop = bar.offset().top + bar.outerHeight();
        barWidth = bar.width();
        wW = 0;
        $(window).scroll(fixPageActions).resize(function()
        {
            var winW = $(window).width();
            if(Math.abs(wW - winW) < 100) return;
            wW = winW;
            bar = $('.page-actions');
            bar.removeClass('fixed');
            bar.css('width', '100%');
            barTop = bar.offset().top + bar.outerHeight();
            barWidth = bar.width();
            fixPageActions();
        });
        fixPageActions();
    }

    function fixPageActions()
    {
        var $win = $(window);
        var wH = $win.height();
        var fixed = barTop > wH && $win.scrollTop() < (barTop - wH);
        if(fixed)
        {
            bar.css('width', barWidth);
        }
        $('body').toggleClass('page-actions-fixed');
        bar.toggleClass('fixed', fixed);
    }
}

/**
 * Reload home.
 * 
 * @access public
 * @return void
 */
function reloadHome()
{
    $('#home').load(createLink('index', 'index') + ' #dashboard', function()
    {
        $('#home #dashboard').dashboard(
        {
            height            : 240,
            draggable         : true,
            afterOrdered      : sortBlocks,
            afterPanelRemoved : deleteBlock
        });

        $('#home .dashboard .refresh-all-panel').click(function()
        {    
            var $icon = $(this).find('.icon-repeat').addClass('icon-spin');
            $('#home .dashboard .refresh-panel').click();
            setTimeout(checkDone, 500);

            function checkDone()
            {    
                if($('#home .dashboard .panel-loading').length)
                {
                    setTimeout(checkDone, 500);
                }
                else
                {
                    $icon.removeClass('icon-spin');
                }
            }    
        });  
    });
    $('#ajaxModal').remove();
    $('.modal-backdrop').remove();
}
