;(function($) {
    /*
    * ui.dropdownchecklist
    *
    * Copyright (c) 2008-2010 Adrian Tosca, Copyright (c) 2010 Ittrium LLC
    * Dual licensed under the MIT (MIT-LICENSE.txt)
    * and GPL (GPL-LICENSE.txt) licenses.
    *
    */
    // The dropdown check list jQuery plugin transforms a regular select html element into a dropdown check list.
    $.widget("ui.dropdownchecklist", {
    	// Some globlals
    	// $.ui.dropdownchecklist.gLastOpened - keeps track of last opened dropdowncheck list so we can close it
    	
        // Creates the drop container that keeps the items and appends it to the document
        _appendDropContainer: function() {
            var wrapper = $("<div/>");
            // the container is wrapped in a div
            wrapper.addClass("ui-dropdownchecklist ui-dropdownchecklist-dropcontainer-wrapper");
            wrapper.addClass("ui-widget");
            // initially hidden
            wrapper.css({ position: 'absolute', left: "-33000px", top: "-33000px"  });
            
            var container = $("<div/>"); // the actual container
            container.addClass("ui-dropdownchecklist-dropcontainer ui-widget-content");
            container.css("overflow-y", "auto");
            wrapper.append(container);
			$(document.body).append(wrapper);

            // flag that tells if the drop container is shown or not
            wrapper.isOpen = false;
            return wrapper;
        },
		_isDropDownKeyShortcut: function(e,keycode) {
			return e.altKey && ($.ui.keyCode.DOWN == keycode);// Alt + Down Arrow
		},
		_isDropDownCloseKey: function(e,keycode) {
			return ($.ui.keyCode.ESCAPE == keycode) || ($.ui.keyCode.ENTER == keycode);
		},
		_keyFocusChange: function(target,delta,limitToItems) {
			// Find item with current focus
			var focusables = $(":focusable");
			var index = focusables.index(target);
			if ( index >= 0 ) {
				index += delta;
				if ( limitToItems ) {
					// Bound change to list of input elements
	            	var allCheckboxes = this.dropWrapper.find("input:not([disabled])");
	            	var firstIndex = focusables.index(allCheckboxes.get(0));
	            	var lastIndex = focusables.index(allCheckboxes.get(allCheckboxes.length-1));
	            	if ( index < firstIndex ) {
	            		index = lastIndex;
	            	} else if ( index > lastIndex ) {
	            		index = firstIndex;
	            	}
	            }
				focusables.get(index).focus();
			}
		},
		// Look for navigation, open, close (wired to keyup)
		_handleKeyboard: function(e) {
			var self = this;
			var keyCode = (e.keyCode || e.which);
			if (!self.dropWrapper.isOpen && self._isDropDownKeyShortcut(e, keyCode)) {
				e.stopImmediatePropagation();
				self._toggleDropContainer(true);
			} else if (self.dropWrapper.isOpen && self._isDropDownCloseKey(e, keyCode)) {
				e.stopImmediatePropagation();
				self._toggleDropContainer(false);
			} else if (self.dropWrapper.isOpen 
					&& (e.target.type == 'checkbox')
					&& ((keyCode == $.ui.keyCode.DOWN) || (keyCode == $.ui.keyCode.UP)) ) {
				e.stopImmediatePropagation();
				self._keyFocusChange(e.target, (keyCode == $.ui.keyCode.DOWN) ? 1 : -1, true);
			} else if (self.dropWrapper.isOpen && (keyCode == $.ui.keyCode.TAB) ) {
				// I wanted to adjust normal 'tab' processing here, but research indicates
				// that TAB key processing is NOT a cancelable event. You have to use a timer
				// hack to pull the focus back to where you want it after browser tab
				// processing completes.  Not going to work for us.
				//e.stopImmediatePropagation();
				//self._keyFocusChange(e.target, (e.shiftKey) ? -1 : 1, true);
           }
		},
		// Look for change of focus ON AN ITEM
		_handleFocus: function(e,focusIn) {
			if (!this.dropWrapper.isOpen) {
				// if the focus changes when the control is NOT open, mark it to show where the focus is/is not
				e.stopImmediatePropagation();
				if (focusIn) {
					this.controlWrapper.find(".ui-dropdownchecklist-selector").addClass("ui-state-hover");
					if ($.ui.dropdownchecklist.gLastOpened != null) {
						$.ui.dropdownchecklist.gLastOpened._toggleDropContainer( false );
					}
				} else {
					this.controlWrapper.find(".ui-dropdownchecklist-selector").removeClass("ui-state-hover");
				}
           	}
       		// If would be nice to detect the control losing focus to a different item on the screen,
       		// but the blur is likely to be delivered to the input items.
       		// Currently, I have no simple way to detect when the control should be closed due to
       		// loss of focus.
		},
        // Creates the control that will replace the source select and appends it to the document
        // The control resembles a regular select with single selection
        _appendControl: function() {
            var self = this, sourceSelect = this.sourceSelect, options = this.options;

            // the control is wrapped in a basic container
            var wrapper = $("<span/>");
            wrapper.addClass("ui-dropdownchecklist ui-dropdownchecklist-selector-wrapper ui-widget");
            wrapper.css({ cursor: "default", overflow: "hidden" });

            // the actual control which you can style
            // inline-block needed to enable 'width' but has interesting problems cross browser
            var control = $("<span/>");
            control.addClass("ui-dropdownchecklist-selector ui-state-default");
            control.css( { display: "inline-block", overflow: "hidden", 'white-space': 'nowrap'} );
            // Setting a tab index means we are interested in the tab sequence
			control.attr("tabIndex", 0);
			control.keyup(function(e) {self._handleKeyboard(e);});
			control.focus(function(e) {self._handleFocus(e,true);});
			control.blur(function(e) {self._handleFocus(e,false);});
            wrapper.append(control);

			// the optional icon (which is inherently a block)
			if (options.icon != null) {
				var iconPlacement = (options.icon.placement == null) ? "left" : options.icon.placement;
	            var anIcon = $("<div/>");
	            anIcon.addClass("ui-icon");
	            anIcon.addClass( (options.icon.toOpen != null) ? options.icon.toOpen : "ui-icon-triangle-1-e");
	            anIcon.css({ 'float': iconPlacement });
	            control.append(anIcon);
			}
            // the text container keeps the control text that is built from the selected (checked) items
            // inline-block needed to enable 'width' but has interesting problems cross browser
            var textContainer = $("<span/>");
            textContainer.addClass("ui-dropdownchecklist-text");
            textContainer.css( {  display: "inline-block", 'white-space': "nowrap", overflow: "hidden" } );
            control.append(textContainer);

            // add the hover styles to the control
            wrapper.hover(
	            function() {
	                if (!self.disabled) {
	                    control.addClass("ui-state-hover");
	                }
	            }
	        , 	function() {
	                if (!self.disabled) {
	                    control.removeClass("ui-state-hover");
	                }
	            }
	        );
            // clicking on the control toggles the drop container
            wrapper.click(function(event) {
                if (!self.disabled) {
                    event.stopPropagation();
                    self._toggleDropContainer( !self.dropWrapper.isOpen );
                }
            });
            wrapper.insertAfter(sourceSelect);

			// Watch for a window resize and adjust the control if open
            $(window).resize(function() {
                if (!self.disabled && self.dropWrapper.isOpen) {
                	// Reopen yourself to get the position right
                    self._toggleDropContainer(true);
                }
            });       
            return wrapper;
        },
        // Creates a drop item that coresponds to an option element in the source select
        _createDropItem: function(index, value, text, checked, disabled, indent) {
            var self = this;
            // the item contains a div that contains a checkbox input and a lable for the text
            // the div
            var item = $("<div/>");
            item.addClass("ui-dropdownchecklist-item");
            item.css({'white-space': "nowrap"});
            var checkedString = checked ? ' checked="checked"' : '';
			var classString = disabled ? ' class="inactive"' : ' class="active"';
			var idBase = (self.sourceSelect.attr("id") || "ddcl");
			// generated id must be a bit unique to keep from colliding
			var id = idBase + '-i' + index;
            var checkBox;
            
            // all items start out disabled to keep them out of the tab order
            if (self.isMultiple) { // the checkbox
                checkBox = $('<input disabled type="checkbox" id="' + id + '"' + checkedString + classString + '/>');
            } else { // the radiobutton
                checkBox = $('<input disabled type="radio" id="' + id + '" name="' + idBase + '"' + checkedString + classString + '/>');
            }
            checkBox = checkBox.attr("index", index).val(value);
            item.append(checkBox);
            // the text
            var label = $("<label for=" + id + "/>");
            label.addClass("ui-dropdownchecklist-text");
            label.css({ cursor: "default" });
            label.text(text);
			if (indent) {
				item.addClass("ui-dropdownchecklist-indent");
			}
			item.addClass("ui-state-default");
			if (disabled) {
				item.addClass("ui-state-disabled");
			}
	        label.click(function(e) {e.stopPropagation();});
            item.append(label);
            
            var checkItem;
            if ( !disabled ) {
            	// active items display themselves with hover
	            item.hover(
	            	function() {
	                	item.addClass("ui-state-hover");
	            	}
	            , 	function() {
	                	item.removeClass("ui-state-hover");
	            	}
	            );
	            // clicking on the checkbox synchronizes the source select
		        checkBox.click(function(e) {
					e.stopPropagation();
					if (!disabled) {
		                self._syncSelected($(this));
		                self.sourceSelect.trigger("change", 'ddcl_internal');
					}
		        });
	            // check/uncheck the item on clicks on the entire item div
	            checkItem = function(e) {
	                e.stopPropagation();
					if (!disabled) {
		                var checked = checkBox.attr("checked");
		                checkBox.attr("checked", !checked);
		                self._syncSelected(checkBox);
		                self.sourceSelect.trigger("change", 'ddcl_internal');
					}
	            };
	        } else {
	        	// nothing interesting when clicking something not active
	            checkItem = function(e) {
	                e.stopPropagation();
				};        
	        }
	        item.click(checkItem);
			item.keyup(function(e) {self._handleKeyboard(e);});
            return item;
        },
		_createGroupItem: function(text) {
			var group = $("<div />");
			group.addClass("ui-dropdownchecklist-group ui-widget-header");
			group.css({'white-space': "nowrap"});
			
            var label = $("<span/>");
            label.addClass("ui-dropdownchecklist-text");
            label.css( { cursor: "default" });
            label.text(text);
			group.append(label);
			return group;
		},
        // Creates the drop items and appends them to the drop container
        // Also calculates the size needed by the drop container and returns it
        _appendItems: function() {
            var self = this, sourceSelect = this.sourceSelect, dropWrapper = this.dropWrapper;
            var dropContainerDiv = dropWrapper.find(".ui-dropdownchecklist-dropcontainer");
			sourceSelect.children().each(function(index) { // when the select has groups
				var opt = $(this);
                if (opt.is("option")) {
                    self._appendOption(opt, dropContainerDiv, index, false);
                } else if (opt.is("optgroup")) {
                    var text = opt.attr("label");
                    var group = self._createGroupItem(text);
                    dropContainerDiv.append(group);
                    self._appendOptions(opt, dropContainerDiv, index, true);
                }
			});
            var divWidth = dropContainerDiv.outerWidth();
            var divHeight = dropContainerDiv.outerHeight();
            return { width: divWidth, height: divHeight };
        },
		_appendOptions: function(parent, container, parentIndex, indent) {
			var self = this;
			parent.children("option").each(function(index) {
                var option = $(this);
                var childIndex = (parentIndex + "." + index);
                self._appendOption(option, container, childIndex, indent);
            });
		},
        _appendOption: function(option, container, index, indent) {
            var self = this;
            var text = option.text();
            var value = option.val();
            var selected = option.attr("selected");
			var disabled = option.attr("disabled");
            var item = self._createDropItem(index, value, text, selected, disabled, indent);
            container.append(item);
        },
        // Synchronizes the items checked and the source select
        // When firstItemChecksAll option is active also synchronizes the checked items
        // senderCheckbox parameters is the checkbox input that generated the synchronization
        _syncSelected: function(senderCheckbox) {
            var self = this, options = this.options, sourceSelect = this.sourceSelect, dropWrapper = this.dropWrapper;
            var allCheckboxes = dropWrapper.find("input:not([disabled])");
            if (options.firstItemChecksAll) {
                // if firstItemChecksAll is true, check all checkboxes if the first one is checked
                if (senderCheckbox.attr("index") == 0) {
                    allCheckboxes.attr("checked", senderCheckbox.attr("checked"));
                } else {
                    // check the first checkbox if all the other checkboxes are checked
                    var allChecked;
                    allChecked = true;
                    allCheckboxes.each(function(index) {
                        if (index > 0) {
                            var checked = $(this).attr("checked");
                            if (!checked) { allChecked = false; }
                        }
                    });
                    var firstCheckbox = allCheckboxes.filter(":first");
                    firstCheckbox.attr("checked", false);
                    if (allChecked) {
                        firstCheckbox.attr("checked", true);
                    }
                }
            }
            // do the actual synch with the source select
            allCheckboxes = dropWrapper.find("input");
            var selectOptions = sourceSelect.get(0).options;
            allCheckboxes.each(function(index) {
                $(selectOptions[index]).attr("selected", $(this).attr("checked"));
            });
            // update the text shown in the control
            self._updateControlText();
        	
        	// Ensure the focus stays pointing where the user is working
        	senderCheckbox.focus();
        },
        _sourceSelectChangeHandler: function(event) {
            var self = this, dropWrapper = this.dropWrapper;
            dropWrapper.find("input").val(self.sourceSelect.val());

        	// update the text shown in the control
        	self._updateControlText();
        },
        // Updates the text shown in the control depending on the checked (selected) items
        _updateControlText: function() {
            var self = this, sourceSelect = this.sourceSelect, options = this.options, controlWrapper = this.controlWrapper;
            var firstOption = sourceSelect.find("option:first");
            var selectOptions = sourceSelect.find("option");
            var text = self._formatText(selectOptions, options.firstItemChecksAll, firstOption);
            var controlLabel = controlWrapper.find(".ui-dropdownchecklist-text");
            controlLabel.html(text);
            controlLabel.attr("title", text);
        },
        // Formats the text that is shown in the control
        _formatText: function(selectOptions, firstItemChecksAll, firstOption) {
            var text;
            if ( $.isFunction(this.options.textFormatFunction) ) {
            	// let the callback do the formatting, but do not allow it to fail
            	try {
                	text = this.options.textFormatFunction(selectOptions);
                } catch(ex) {
                	alert( 'textFormatFunction failed: ' + ex );
                }
            } else if (firstItemChecksAll && (firstOption != null) && firstOption.attr("selected")) {
                // just set the text from the first item
                text = firstOption.text();
            } else {
                // concatenate the text from the checked items
                text = "";
                selectOptions.each(function() {
                    if ($(this).attr("selected")) {
                        if ( text != "" ) { text += ", "; }
                        text += $(this).text();
                    }
                });
                if ( text == "" ) {
                    text = (this.options.emptyText != null) ? this.options.emptyText : "&nbsp;";
                }
            }
            return text;
        },
        // Shows and hides the drop container
        _toggleDropContainer: function( makeOpen ) {
            var self = this;
            // hides the last shown drop container
            var hide = function(instance) {
                if ((instance != null) && instance.dropWrapper.isOpen ){
                    instance.dropWrapper.isOpen = false;
                    $.ui.dropdownchecklist.gLastOpened = null;

	            	var config = instance.options;
                    instance.dropWrapper.css({
                        top: "-33000px",
                        left: "-33000px"
                    });
                    var aControl = instance.controlWrapper.find(".ui-dropdownchecklist-selector");
	                aControl.removeClass("ui-state-active");
	                aControl.removeClass("ui-state-hover");

                    var anIcon = instance.controlWrapper.find(".ui-icon");
                    if ( anIcon.length > 0 ) {
                    	anIcon.removeClass( (config.icon.toClose != null) ? config.icon.toClose : "ui-icon-triangle-1-s");
                    	anIcon.addClass( (config.icon.toOpen != null) ? config.icon.toOpen : "ui-icon-triangle-1-e");
                    }
                    $(document).unbind("click", hide);
                    
                    // keep the items out of the tab order by disabling them
                    instance.dropWrapper.find("input.active").attr("disabled","disabled");
                    
                    // the following blur just does not fire???  because it is hidden???  because it does not have focus???
			  		//instance.sourceSelect.trigger("blur");
			  		//instance.sourceSelect.triggerHandler("blur");
			  		if($.isFunction(config.onComplete)) { try {
			     		config.onComplete.call(instance,instance.sourceSelect.get(0));
                    } catch(ex) {
                    	alert( 'callback failed: ' + ex );
                    }}
                }
            };
            // shows the given drop container instance
            var show = function(instance) {
            	if ( !instance.dropWrapper.isOpen ) {
	                instance.dropWrapper.isOpen = true;
	                $.ui.dropdownchecklist.gLastOpened = instance;

	            	var config = instance.options;
	                instance.dropWrapper.css({
	                    top: instance.controlWrapper.offset().top + instance.controlWrapper.outerHeight() + "px",
	                    left: instance.controlWrapper.offset().left + "px"
	                });
					var ancestorsZIndexes = instance.controlWrapper.parents().map(
						function() {
							var zIndex = $(this).css("z-index");
							return isNaN(zIndex) ? 0 : zIndex; }
						).get();
					var parentZIndex = Math.max.apply(Math, ancestorsZIndexes);
					if (parentZIndex > 0) {
						instance.dropWrapper.css({
							zIndex: (parentZIndex+1)
						});
					}
	                var aControl = instance.controlWrapper.find(".ui-dropdownchecklist-selector");
	                aControl.addClass("ui-state-active");
	                aControl.removeClass("ui-state-hover");
	                
	                var anIcon = instance.controlWrapper.find(".ui-icon");
	                if ( anIcon.length > 0 ) {
	                	anIcon.removeClass( (config.icon.toOpen != null) ? config.icon.toOpen : "ui-icon-triangle-1-e");
	                	anIcon.addClass( (config.icon.toClose != null) ? config.icon.toClose : "ui-icon-triangle-1-s");
	                }
	                $(document).bind("click", function(e) {hide(instance);} );
	                
                    // insert the items back into the tab order by enabling all active ones
                    var activeItems = instance.dropWrapper.find("input.active");
                    activeItems.removeAttr("disabled");
                    
                    // we want the focus on the first active input item
                    var firstActiveItem = activeItems.get(0);
                    if ( firstActiveItem != null ) {
                    	firstActiveItem.focus();
                    }
			    }
            };
            if ( makeOpen ) {
            	hide($.ui.dropdownchecklist.gLastOpened);
            	show(self);
            } else {
            	hide(self);
            }
        },
        // Set the size of the control and of the drop container
        _setSize: function(dropCalculatedSize) {
            var options = this.options, dropWrapper = this.dropWrapper, controlWrapper = this.controlWrapper;

            // use the width from config options if set, otherwise set the same width as the drop container
            var controlWidth = dropCalculatedSize.width;
            if (options.width != null) {
                controlWidth = parseInt(options.width);
            } else if (options.minWidth != null) {
                var minWidth = parseInt(options.minWidth);
                // if the width is too small (usually when there are no items) set a minimum width
                if (controlWidth < minWidth) {
                    controlWidth = minWidth;
                }
            }
            var control = controlWrapper.find(".ui-dropdownchecklist-selector");
            control.css({ width: controlWidth + "px" });
            
            // if we size the text, then Firefox places icons to the right properly
            // and we do not wrap on long lines
            var controlText = control.find(".ui-dropdownchecklist-text");
            var controlIcon = control.find(".ui-icon");
            if ( controlIcon != null ) {
            	// Must be an inner/outer/border problem, but IE6 needs an extra bit of space
            	controlWidth -= (controlIcon.outerWidth() + 6);
            	controlText.css( { width: controlWidth + "px" } );
            }
            // Account for padding, borders, etc
            controlWidth = controlWrapper.outerWidth();
            
            // the drop container height can be set from options
            var dropHeight = (options.maxDropHeight != null)
            					? parseInt(options.maxDropHeight) 
            					: dropCalculatedSize.height;
            // ensure the drop container is not less than the control width (would be ugly)
            var dropWidth = dropCalculatedSize.width < controlWidth ? controlWidth : dropCalculatedSize.width;

            $(dropWrapper).css({
                height: dropHeight + "px",
                width: dropWidth + "px"
            });
            dropWrapper.find(".ui-dropdownchecklist-dropcontainer").css({
                height: dropHeight + "px"
            });
        },
        // Initializes the plugin
        _init: function() {
            var self = this, options = this.options;

            // sourceSelect is the select on which the plugin is applied
            var sourceSelect = self.element;
            self.initialDisplay = sourceSelect.css("display");
            sourceSelect.css("display", "none");
            self.initialMultiple = sourceSelect.attr("multiple");
            self.isMultiple = self.initialMultiple;
            if (options.forceMultiple != null) { self.isMultiple = options.forceMultiple; }
            sourceSelect.attr("multiple", true);
            self.sourceSelect = sourceSelect;

            // create the drop container where the items are shown
            var dropWrapper = self._appendDropContainer();
            self.dropWrapper = dropWrapper;

            // append the items from the source select element
            var dropCalculatedSize = self._appendItems();

            // append the control that resembles a single selection select
            var controlWrapper = self._appendControl();
            self.controlWrapper = controlWrapper;

            // updates the text shown in the control
            self._updateControlText(controlWrapper, dropWrapper, sourceSelect);

            // set the sizes of control and drop container
            self._setSize(dropCalculatedSize);

            // BGIFrame for IE6
			if (options.bgiframe && typeof self.dropWrapper.bgiframe == "function") {
				self.dropWrapper.bgiframe();
			}
          	// listen for change events on the source select element
          	// ensure we avoid processing internally triggered changes
          	self.sourceSelect.change(function(event, eventName) {
	            if (eventName != 'ddcl_internal') {
	                self._sourceSelectChangeHandler(event);
	            }
	        });
        },
        enable: function() {
            this.controlWrapper.find(".ui-dropdownchecklist-selector").removeClass("ui-state-disabled");
            this.disabled = false;
        },
        disable: function() {
            this.controlWrapper.find(".ui-dropdownchecklist-selector").addClass("ui-state-disabled");
            this.disabled = true;
        },
        destroy: function() {
            $.widget.prototype.destroy.apply(this, arguments);
            this.sourceSelect.css("display", this.initialDisplay);
            this.sourceSelect.attr("multiple", this.initialMultiple);
            this.controlWrapper.unbind().remove();
            this.dropWrapper.remove();
        }
    });

    $.extend($.ui.dropdownchecklist, {
        defaults: {
            width: null,
            maxDropHeight: null,
            firstItemChecksAll: false,
            minWidth: 50,
            bgiframe: false
        }
    });

})(jQuery);