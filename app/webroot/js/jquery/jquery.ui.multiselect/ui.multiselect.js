/**
 * jQuery UI Multiselect
 *
 * Author:
 *  Ber Clausen (crashcookie at gmail com)
 *
 * License:
 *  GPL
 *
 * Depends:
 *	ui.core.js
 *
 * Optional:
 *  localization (http://plugins.jquery.com/project/localisation)
 *  scrollTo (http://plugins.jquery.com/project/ScrollTo)
 *
 * Todo:
 *  dunno now
 *
 * Widget A: target widget
 * Widget B: this widget
 *
 */


(function($) {

$.widget('ui.multiselect', {
	options: {
		locale: {
			addAllItems:'add all',
			removeAllItems:'remove all',
			saveAll: 'save all',
			cancelAll: 'cancel all',
			selected:'selected',
			aItem: 'A item',
			nameOfAItem: 'name of A item',
			mark: 'mark'
		},
		searchable: true,
		searchViewAll: true,
		animated: 'fast',
		show: 'slideDown',
		hide: 'slideUp',
		dividerLocation: 0.5,
		nodeComparator: function(node1,node2) {
			var text1 = node1.text(),
				text2 = node2.text();
			return text1 == text2 ? 0 : (text1 < text2 ? -1 : 1);
		},
		target: null,
		aModel: 'model a',
		bModel: 'model b',
		editAction: 'edit',
		markAction: 'mark',
		aggresiveSearchTrigger: 1500
	},

	_create: function()
	{
		var that = this;
		// number of options in select list
		this.count = 0;
		// number of currently selected options
		this.selectedCount = 0;

		// live search cache handling
		this.searchListCache = '';
		this.aggresiveSearch = false;
		this.expiredSearchListCache = true;
		// cache dictionary for fast indexing
		this.dictionaryCache = '';

		// multiselect
		this.element.hide();
		this.elementWidth = this.element.width();
		this.elementHeight = this.element.height();
		this.id = this.element.attr('id');
		this.element.attr('name', 'data['+this.options.bModel+']['+this.options.bModel+'][]');

		// create form
		this.formContainer = $('<form action="'+this.options.editAction+'.json" method="post" enctype="multipart/form-data" id="widgetBForm"></form>');
		this.element.wrapAll(this.formContainer);
		this.itemData = $(
			'<div id="msItemData" class="input">' +
				'<label for="aItemName">'+this.options.locale.nameOfAItem+'</label>' +
				'<div id="msItemName">' +
					'<input type="text" id="aItemName" value="" name="data['+this.options.aModel+'][name]">' +
					'<input type="text" id="aItemSlug" disabled value="" name="">' +
				'</div>' +
				'<label for="aItemMark">'+this.options.locale.mark+'</label>' +
				'<div id="msItemState">' +
					'<input type="checkbox" id="aItemMark" name="">' +
					'<span id="aItemMarkTxt"/>' +
				'</div>' +
				'<input type="hidden" id="aItemID" value="" name="data['+this.options.aModel+'][id]">' +
			'</div>'
		).insertAfter(this.element);
		this.saveAll = $(
			'<div id="msActions" class="submit">' +
				'<input id="msCancelAll" type="button" value="'+this.options.locale.cancelAll+'" class="btn mrs">' +
				'<input id="msSaveAll" type="submit" value="'+this.options.locale.saveAll+'" class="btn">' +
			'</div>'
		).insertAfter(this.itemData);

		// create containers
		this.container = $('<div class="ui-multiselect ui-helper-clearfix ui-widget"></div>').insertAfter(this.element);
		this.availableContainer = $('<div class="available"></div>').appendTo(this.container);
		this.selectedContainer = $('<div class="selected"></div>').appendTo(this.container);

		// create actions
		this.availableActions = $('<div class="actions ui-widget-header ui-helper-clearfix"><input type="text" class="search empty ui-widget-content ui-corner-all"/><span class="searchIcon ui-icon ui-icon-search"/><a href="#" id="msAddAll">'+this.options.locale.addAllItems+'</a></div>').appendTo(this.availableContainer);
		this.selectedActions = $('<div class="actions ui-widget-header ui-helper-clearfix"><span id="selectedCount" class="count">0 '+this.options.locale.selected+'</span><div class="loadingSmall"></div><a href="#" id="msRemoveAll">'+this.options.locale.removeAllItems+'</a></div>').appendTo(this.selectedContainer);
		// create lists
		this.availableList = $('<ul class="available connected-list"><li class="ui-helper-hidden-accessible"></li></ul>').bind('selectstart', function(){return false;}).appendTo(this.availableContainer);
		this.selectedList = $('<ul class="selected connected-list"><li class="ui-helper-hidden-accessible"></li></ul>').bind('selectstart', function(){return false;}).appendTo(this.selectedContainer);

		// set containers width
		this.container.width(this.elementWidth);
		this.availableContainer.width(Math.floor(this.elementWidth*this.options.dividerLocation));
		this.selectedContainer.css("border-left","1px solid").width(Math.floor(this.elementWidth*(1-this.options.dividerLocation)-1));
		// set containers height
		var itemDataHight = this.itemData.outerHeight(true);
		this.availableList.height(Math.max(this.elementHeight-this.availableActions.height()-itemDataHight,1));
		this.selectedList.height(Math.max(this.elementHeight-this.selectedActions.height()-itemDataHight,1));


		/**
		 *  Populate widget B lists
		 */
		this._populateLists(this.element.children('option'));

		// delegate handlers to available list elements
		this.availableList.delegate('li', 'click', function(e) {
//			that._setSelected($(e.currentTarget), true);
			that._setSelected($(this), true);
			that.selectedCount += 1;
			that._updateCount();
			return false;
		})
		.delegate('li', 'mouseenter', function() {
			$(this).addClass('ui-state-hover');
		})
		.delegate('li', 'mouseleave', function() {
			$(this).removeClass('ui-state-hover');
		});

		// delegate handlers to selected list elements
		this.selectedList.delegate('li', 'click', function(e) {
//			that._setSelected($(e.currentTarget), false);
			that._setSelected($(this), false);
			that.selectedCount -= 1;
			that._updateCount();
			return false;
		})
		.delegate('li', 'mouseenter', function() {
			$(this).addClass('ui-state-hover');
		})
		.delegate('li', 'mouseleave', function() {
			$(this).removeClass('ui-state-hover');
		});


		/**
		 *  Set widget A options
		 */
		// animation options
		if(!this.options.animated) {
			this.options.show = 'show';
			this.options.hide = 'hide';
		}
		// set up livesearch
		if(this.options.searchable) {
			this._registerSearchEvents(this.availableActions.children('input.search:first'));
			this.availableActions.children('.searchIcon').click(function() {
				that._filter.apply(that.availableActions.children('input.search:first'), [that.availableList, that.searchListCache]);
			});
		}else {
			this.find('.search').hide();
		}


		/**
		 *  Set 'unselect all B items' (widget B)
		 */
		this.selectedActions.children('#msRemoveAll').click(function() {
			that._populateLists(that.element.children('option').removeAttr('selected'));
			return false;
		});


		/**
		 *  Set 'select all B items' (widget B)
		 */
		this.availableActions.children('#msAddAll').click(function() {
			that._populateLists(that.element.children('option').attr('selected', 'selected'));
			return false;
		});


		/**
		 *  Save current state: A item with selected B items
		 *  Set A item (widget A)
		 *  Clear widget A & B
		 */
		// register AJAX call
		$('#widgetBForm').submit(function(e) {
			e.preventDefault();
			$.ajax({
				url: $(this).attr('action'),
				data: $(this).serialize(),
				dataType: 'json',
				type: 'POST',
				success: function(response) {
					if(response.id != false) {
						// clear widget A
						that._clearWidgetA();
						// set A item (widget A)
						that._setAItem(response.id, response.name, response.slug, response.mark);
					}
				}
			});
		});


		// supress enter key on form fields to avoid accidental submits
		$('form input').keydown(function(event) {
			if(event.keyCode == 13 && event.target.type != 'submit') return false;
		});

		/**
		 *  Cancel A & B items save
		 *  Clear widget A & B
		 */
		$('form input#msCancelAll').unbind().click(function() {
			// clear widget A and indirectly, widget B
			that._clearWidgetA();
		});

		$('#aItemMark').unbind().click(function() {
			var checked = $(this).is(':checked');
			optionValue = that.itemData.find('#aItemID').val();

			// option value is not number > prevent checking and die quietly
			if(isNaN(optionValue) || optionValue=='') {
				$(this).attr('checked', false);
				return false;
			}

			// mark A item
			$.ajax({
				url: that.options.markAction + '/' + optionValue,
				dataType: 'json',
				success: function(response) {
					that.itemData.find('#aItemMarkTxt').text(response.message).css('visibility', 'visible');
					if(response.id != false) {
						if (response.status) {
							// mark A item (widget A)
							that._markAItem(response.id);
						} else {
							// mark A item (widget A)
							that._unmarkAItem(response.id);
						}
					}
				}
			});
		});
	},

	destroy: function()
	{
		this.element.show();
		this.container.remove();

		$.Widget.prototype.destroy.call(this);
	},



	/**
	 *  PUBLIC METHODS
	 */

	// clear widget B
	clearWidgetB: function()
	{
		this._unselectSelectedItems();
	},

	// set A item (widget B)
	setAItem: function(itemID, itemName, itemSlug, itemMark)
	{
		if(itemID && itemName && itemSlug && itemMark) {
			itemMark = (parseInt(itemMark)) ? true : false;

			this.itemData.find('#aItemID').val(itemID);
			this.itemData.find('#aItemName').val(itemName).attr('title', itemName);
			this.itemData.find('#aItemSlug').val(itemSlug).attr('title', itemSlug);;
			this.itemData.find('#aItemMark').attr('checked', itemMark);
		}else {
			this.itemData.find('#aItemID').val('');
			this.itemData.find('#aItemName').val('').attr('title', '');
			this.itemData.find('#aItemSlug').val('').attr('title', '');
			this.itemData.find('#aItemMark').attr('checked', false);
		}
		this.itemData.find('#aItemMarkTxt').css('visibility', 'hidden');
	},

	// select B items (widget B) via AJAX call
	selectBItems: function(optionValueArray)
	{
		for(var i=0; i < optionValueArray.length; i++) {
			this._selectBItem(optionValueArray[i]);
		}
	},


	/**
	 *  PRIVATE METHODS
	 */

	// get 'option id' from 'option value'
	_getOptionID: function(optionValue)
	{
		var optionID = this.dictionaryCache[optionValue];
		if(optionID != undefined) {
			return optionID;
		}
		return null;
	},

	// get 'option id' from 'list element'
	_getOptionIDFromListElement: function(listElement)
	{
		return listElement.attr('id').replace('option-','');
	},

	// get 'option' from 'option id'
	_getOptionFromID: function(optionID)
	{
		return $(this.element[0].options[optionID]);
	},

	// get 'option' from 'list element'
	_getOptionFromListElement: function(listElement)
	{
		return this._getOptionFromID(this._getOptionIDFromListElement(listElement));
	},


	/**
	 *  Widget A
	 */

	// clear widget A
	_clearWidgetA: function()
	{
		this.options.target.multiselectStripped('clearWidgetA');
	},

	// mark A item (widget A)
	_markAItem: function(itemID)
	{
		this.options.target.multiselectStripped('markAItem', {'id':itemID});
	},

	// mark A item (widget A)
	_unmarkAItem: function(itemID)
	{
		this.options.target.multiselectStripped('unmarkAItem', {'id':itemID});
	},

	// set A item (widget A)
	_setAItem: function(itemID, itemName, itemSlug, itemMark)
	{
		this.options.target.multiselectStripped('setAItem', {'id':itemID, 'name':itemName, 'slug':itemSlug, 'mark':itemMark});
	},


	/**
	 *  Widget B
	 */

	// select B item (widget B) via AJAX call
	_selectBItem: function(optionValue)
	{
		var optionID = this._getOptionID(optionValue);
		if(optionID == null) {
			return;
		}


		/* need a fix > is taking to much time */

//		$.consoleTime('selectBItem');
//		this.availableList.children('li#option-'+optionID).css('display','block').click();
		$('li#option-'+optionID, this.availableList).css('display','block').click();
//		$.consoleTimeEnd('selectBItem');



	},

	// update number of currently selected options (B items in selected list)
	_updateCount: function()
	{
		$('#selectedCount').text(this.selectedCount+' '+this.options.locale.selected);
	},

	// unselect selected B items (widget B)
	_unselectSelectedItems: function()
	{
		var selectedItems = this.selectedList.children('li');
		var selectedItemsCount = selectedItems.size();
		if(selectedItemsCount != 0) {
			if(selectedItemsCount <= 20) {
				// trigger click event if few elements selected
				selectedItems.map(function() {
					$(this).click();
				});
			}else {
				// remove all B items and repopulate widget B
				this.selectedActions.children('#msRemoveAll').click();
			}
		}
		// expire search cache
		this.expiredSearchListCache = true;
	},

	// set selected/unselected state to B item (widget B)
	_setSelected: function(listElement, selected)
	{
		var optionID = this._getOptionIDFromListElement(listElement);
		this._getOptionFromID(optionID).attr('selected', selected);

		if(selected) {
			// to selectedList
			listElement.children('span').addClass('ui-icon-minusthick').removeClass('ui-icon-plusthick');
			listElement.removeClass('ui-state-hover');
			listElement.prependTo(this.selectedList);
		}else {
			// to availableList
			listElement.children('span').addClass('ui-icon-plusthick').removeClass('ui-icon-minusthick');
			listElement.removeClass('ui-state-hover');

			var currentListElementID = optionID;
			var currentListElement = [];

			while(currentListElement.length == 0 && currentListElementID > 0) {
				currentListElementID -= 1;
				currentListElement = $('li#option-'+currentListElementID, this.availableList);
			};

			if(currentListElement.length == 0) {
				this.availableList.prepend(listElement);
			}else {
				currentListElement.after(listElement);
			}
		}
		this.expiredSearchListCache = true;

		return false;
	},

	// regenerate search cache (widget B)
	_regenerateSearchListCache: function()
	{
		this.searchListCache = this.availableList.children('li').map(function(){
			return $(this).text().toLowerCase();
		});
		this.expiredSearchListCache = false;
	},

	// register search events (widget B)
	_registerSearchEvents: function(input)
	{
		var that = this;
		this._regenerateSearchListCache();

		this.aggresiveSearch = (this.count <= this.options.aggresiveSearchTrigger) ? true : false;

		// unbind previous binded events
		input.unbind('focus').unbind('blur').unbind('keyup.multiselect').unbind('keydown.multiselect');

		input.bind('focus', function() {
			//that.itemData.find('#aItemMark').click();
//			$.log(that.count);
//			$.log(that.aggresiveSearch);
			$(this).addClass('ui-state-active');
			if(that.expiredSearchListCache) {
				that._regenerateSearchListCache();
			}
		})
		.bind('blur', function() {
			$(this).removeClass('ui-state-active');
		})
		.bind('keyup.multiselect', function(e) {
			var keyCode = $.ui.keyCode;
			switch(e.keyCode) {
				case keyCode.ESCAPE:
					$(this).val('');
					that._filter.apply(this, [that.availableList, that.searchListCache]);
					break;
				default:
					if(that.aggresiveSearch) {
						that._filter.apply(this, [that.availableList, that.searchListCache]);
					}
					break;
			}
		})
		.bind('keydown.multiselect', function(e) {
			var keyCode = $.ui.keyCode;
			switch(e.keyCode) {
				case keyCode.TAB:
					e.preventDefault();
				case keyCode.ENTER:
					that._filter.apply(this, [that.availableList, that.searchListCache]);
					break;
				case keyCode.ESCAPE:
				case keyCode.SHIFT:
				case keyCode.CONTROL:
				case 18:
					// ignore escape & metakeys (shift, ctrl, alt)
					break;
				default:
					break;
			}
		});
	},

	// filter B list elements when searching (widget B)
	_filter: function(list, listCache)
	{
		var input = $(this);
		var searchTerm = $.trim(input.val().toLowerCase());
		var rows = list.children('li');
		var scores = [];

		if(this.cachedTerm == searchTerm) {
				//$.log('is cached');
				return;
		}
		this.cachedTerm = searchTerm;

		if(searchTerm.length<3) {
			//$.log('too short');
			if(rows.is(':hidden')) {
				//$.log('start repopulate');
				var start = 0;
				var end = 0;
				var offset = 100;
				var bounds = [];

				do {
					end = start + offset;
					bounds.push([start,end]);
					start += offset;
				}while(end < rows.size());
				bounds.reverse();

				var bound = null;
				for(var i=0; i<bounds.length; i++) {
					//$.log('timer '+i);
					window.setTimeout(function() {
						bound = bounds.pop();
						currentRows = rows.slice(bound[0], bound[1]);
						currentRows.css('display','block');
						//$.log(currentRows);
						//$.log(currentRows.last());
					}, i*50);
				}

				/*currentRows = rows.slice(start, end);
				currentRows.css('display','block');
				$.log(currentRows.size());
				$.log(currentRows);*/
			}
			return;
		}

		if(searchTerm) {
			//$.log('match!');
			rows.css('display','none');
			listCache.each(function(i) {
				if(this.indexOf(searchTerm) >= 0) {
					scores.push(i);
				}
			});
			$.each(scores, function() {
				$(rows[this]).css('display','block');
			});
		}
	},

	// populate widget B lists
	_populateLists: function(options)
	{
		var that = this;
		var count = 0;
		var selectedCount = 0;
		var optionText = null;
		var dictionary = [];
		var selectedList = '';
		var availableList = '';
		//this.selectedList.children('.ui-element').remove();
		//this.availableList.children('.ui-element').remove();

		for (var i=0; i< options.length; i++) {
			optionText = options[i].text;
			dictionary[options[i].value] = i;

			if (options[i].selected) {
				selectedList += '<li id="option-'+i+'" class="ui-state-default ui-element" title="'+optionText+'">'+
									optionText+
									'<span class="ui-corner-all ui-icon ui-icon-minusthick"/>'+
								'</li>';
				selectedCount += 1;
			} else {
				availableList += '<li id="option-'+i+'" class="ui-state-default ui-element" title="'+optionText+'">'+
									optionText+
									'<span class="ui-corner-all ui-icon ui-icon-plusthick"/>'+
								'</li>';
			}
			count += 1;
		}
		this.count = count;
		this.selectedCount = selectedCount;

		// create FIXED dictionary for fast indexing
		this.dictionaryCache = dictionary;

		// insert list items in proper container
		this.selectedList.html(selectedList);
		this.availableList.html(availableList);

		// update selected items count
		this._updateCount();
	}

/*	_loadingSmall: function(status)
	{
		var loader = this.selectedActions.children('.loadingSmall:first');
		if(status==true) {
			loader.css('visibility','visible');
		}else {
			loader.css('visibility','hidden');
		}
	},*/

/*	_loadingBig: function(status)
	{
		var loader = this.loadingContainer;
		if(status==true) {
			loader.css('visibility','visible');
		}else {
			loader.css('visibility','hidden');
		}
	},*/

});

})(jQuery);
