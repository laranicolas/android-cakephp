/**
 * jQuery UI Multiselect Stripped
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
 * Widget A: this widget
 * Widget B: target widget
 *
 */


(function($) {

$.widget('ui.multiselectStripped', {
	options: {
		locale: {
			addItem: 'add',
			deleteItem: 'delete',
			nameOfAItem: 'name of A item'
		},
		searchable: true,
		animated: 'fast',
		show: 'slideDown',
		hide: 'slideUp',
		nodeComparator: function(node1,node2) {
			var text1 = node1.text(),
				text2 = node2.text();
			return text1 == text2 ? 0 : (text1 < text2 ? -1 : 1);
		},
		target: null,
		loading: '/img/webart/loading.gif', /*(Flag: image-multi-loading)*/
		aModel: 'model a',
		addAction: 'add',
		deleteAction: 'delete',
		getBItemsAction: 'get_b-items',
		aggresiveSearchTrigger: 1500
	},

	_create: function()
	{
		var that = this;
		// number of options in select list
		this.count = 0;

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

		// create containers
		this.container = $('<div class="ui-multiselect ui-helper-clearfix ui-widget"></div>').insertAfter(this.element);
		this.loadingContainer = $('<div class="loadingBig"><img src="'+this.options.loading+'" width="25" height="25"></div>').appendTo(this.container);
		this.availableContainer = $('<div class="available"></div>').appendTo(this.container);
		this.formContainer = $(
			'<form action="'+this.options.addAction+'.json" method="post" enctype="multipart/form-data" id="widgetAForm">' +
				'<div class="input"><label for="itemName">'+this.options.locale.nameOfAItem+'</label><input type="text" id="itemName" value="" name="data['+this.options.aModel+'][name]"></div>' +
				'<div class="submit"><input type="submit" value="'+this.options.locale.addItem+'" class="btn"></div>' +
			'</form>'
		).appendTo(this.container);

		// create upper actions bar
		this.upperBar = $('<div class="actions ui-widget-header ui-helper-clearfix"><input type="text" class="search searchStripped empty ui-widget-content ui-corner-all"/><span class="searchIcon ui-icon ui-icon-search"/><div class="loadingSmall"></div></div>').appendTo(this.availableContainer);
		// create lists
		this.availableList = $('<ul class="available connected-list"><li class="ui-helper-hidden-accessible"></li></ul>').bind('selectstart', function(){return false;}).appendTo(this.availableContainer);
		// create lower actions bar
		this.lowerBar = $('<div class="actions ui-widget-header ui-helper-clearfix"><a href="#" id="mssDeleteItem">'+this.options.locale.deleteItem+'</a><a href="#" id="mssAddItem">'+this.options.locale.addItem+'</a></div>').appendTo(this.availableContainer);

		// set containers width
		this.container.width(this.elementWidth);
		this.availableContainer.width(this.elementWidth);
		// set containers height
		this.availableList.height(Math.max(this.elementHeight-this.upperBar.height()-this.lowerBar.height(),1));


		/**
		 *  Populate widget A list
		 */
		this._populateLists(this.element.children('option'));

		// delegate handlers to selected list elements
		this.availableList.delegate('li', 'click', function(e) {
//			var listElement = $(e.currentTarget);
			var listElement = $(this);
			if (listElement.hasClass('ui-state-active')) {
				that._setSelected(listElement, false);
				that._clearWidgetB();
			} else {
				that._setSelected(listElement, true);
				that._clearWidgetB();
				that._editAItem(listElement);
			}
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
		// set loading animation position
		this._centerElement(this.loadingContainer, $(window));
		// set up animation
		if (!this.options.animated) {
			this.options.show = 'show';
			this.options.hide = 'hide';
		}
		// set up livesearch
		if (this.options.searchable) {
			this._registerSearchEvents(this.upperBar.children('input.search:first'));
			this.upperBar.children('.searchIcon').click(function() {
				that._filter.apply(that.upperBar.children('input.search:first'), [that.availableList, that.searchListCache]);
			});
		} else {
			this.find('.search').hide();
		}


		/**
		 *  Register global ajax events
		 */
		this.container.ajaxStart(function() {
			that.showLoadingAnimation(true);
		})
		.ajaxStop(function(){
			that.showLoadingAnimation(false);
		});


		/**
		 *  Set 'add A item' (widget A)
		 */
		// register AJAX call
		$('#widgetAForm').submit(function(e) {
			e.preventDefault();
			$.ajax({
				url: $(this).attr('action'),
				data: $(this).serialize(),
				dataType: 'json',
				type: 'POST',
				success: function(response) {
					if (response && response.id != false) {
						$('#widgetAForm').dialog('close');
						// prepend option to select list (unmarked)
						that.element.prepend('<option value="0|'+response.id+'|'+response.slug+'">'+response.name+'</option>');
						// prepend list element to available list
						that.availableList.prepend(
							'<li id="option-'+response.id+'" class="ui-state-default ui-element" title="['+response.id+'] '+response.name+'">'+
								response.name+
								'<span class="ui-corner-all ui-icon ui-icon-folder-collapsed"/>'+
							'</li>'
						);

						// repopulate list elements
						//that._populateLists(that.element.children('option'));

						// repopulate list elements removing selected items
						//that._populateLists(that.element.children('option').removeAttr('selected'));

						// increment number of options in select list
						that._updateCount(+1);

						// expire search cache
						that.expiredSearchListCache = true;
						// regenerate dictionary for fast indexing
						that._regenerateDictionaryCache();
					}
				}
			});
		});

		// attach dialog behavior to form
		$('#widgetAForm').dialog({
			modal: true,
			autoOpen: false,
			show: 'blind',
			hide: 'drop',
			resizable: false
		});
		// set 'click' event handler
		this.lowerBar.find('#mssAddItem').click(function(e) {
			e.preventDefault();
			$('#widgetAForm').dialog('open');
		});

		// supress enter key on form fields to avoid accidental submits
		$('form input').keydown(function(event) {
			if (event.keyCode == 13 && event.target.type != 'submit') return false;
		});


		/**
		 *  Set 'delete A item' (widget A)
		 */
		// register AJAX call
		this.availableContainer.find('#mssDeleteItem').click(function() {
			that.element.find('option:selected').map(function() {
				var optionElement = $(this);
				var optionValues = optionElement.val().split('|');
				//var optionMark = parseInt(optionValues[0]);
				var optionValue = optionValues[1];

				var listElement = that.availableList.children('li[id=option-'+optionValue+']');

				// option value is not number > die quietly
				if (isNaN(optionValue) || optionValue=='') return;

				$.ajax({
					type: 'DELETE',
					url: that.options.deleteAction + '/' + optionValue,
					dataType: 'json',
					success: function(response) {
						if (response && response.id != false) {
							// clear widget B
							that._clearWidgetB();
							// remove option from select list
							optionElement.remove();
							// remove list element from available list
							listElement.remove();

							// decrement number of options in select list
							that._updateCount(-1);

							// expire search cache
							that.expiredSearchListCache = true;
							// regenerate dictionary for fast indexing
							that._regenerateDictionaryCache();
						}
					}
				});
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

	// not publicly used right now
	// show/hide loading animation
	showLoadingAnimation: function(status)
	{
		var loader = this.loadingContainer;
		if (status==true) {
			loader.css('visibility','visible');
		} else {
			loader.css('visibility','hidden');
		}
	},

	// clear widget A via AJAX call
	clearWidgetA: function()
	{
		this._unselectSelectedItems();
	},

	// mark A item (widget A)
	markAItem: function(item)
	{
		if (item.id) {
			var optionID = this._getOptionID(item.id);
			var optionElement = this._getOptionFromID(optionID);
			var listElement = this.availableList.children('li#option-'+item.id);

			// get A item (widget A)
			var aItem = this._getAItem(listElement);
			// can't get full item > die quietly
			if (!aItem) return;

			// mark option element
			optionElement.val('1|'+item.id+'|'+item.slug);

			// mark list element
			listElement.addClass('ui-state-error');
		}
	},

	// unmark A item (widget A)
	unmarkAItem: function(item)
	{
		if (item.id) {
			var optionID = this._getOptionID(item.id);
			var optionElement = this._getOptionFromID(optionID);
			var listElement = this.availableList.children('li#option-'+item.id);

			// get A item (widget A)
			var aItem = this._getAItem(listElement);
			// can't get full item > die quietly
			if (!aItem) return;

			// mark option element
			optionElement.val('0|'+item.id+'|'+item.slug);

			// mark list element
			listElement.removeClass('ui-state-error');
		}
	},

	// set A item (widget A) via AJAX call
	setAItem: function(item)
	{
		if (item.id && item.name && item.slug) {
			var optionID = this._getOptionID(item.id);
			var optionElement = this._getOptionFromID(optionID);
			var listElement = this.availableList.children('li#option-'+item.id);

			// mark/unmark list element
			(parseInt(item.mark)) ? listElement.addClass('ui-state-error') : listElement.removeClass('ui-state-error');

			optionElement.val(item.mark+'|'+item.id+'|'+item.slug);
			optionElement.text(item.name);

			listElementContent = listElement.html().replace(listElement.text(), item.name);
			listElement.attr('title', '['+item.id+'] '+item.name);
			listElement.html(listElementContent);

			// regenerate search cache explicitly
			this._regenerateSearchListCache();
		}
	},



	/**
	 *  PRIVATE METHODS
	 */

	// center 'children element' based on a 'parent element'
	_centerElement: function (element, parent) {
		var offsetTop = parent[0].offsetTop;
		var offsetLeft = parent[0].offsetLeft;
		(offsetTop == undefined) ? offsetTop = 0 : '';
		(offsetLeft == undefined) ? offsetLeft = 0 : '';
		element.css('position', 'absolute');
		element.css('top', offsetTop + ( parent.height() - element.height() ) / 2+parent.scrollTop() + 'px');
		element.css('left', offsetLeft + ( parent.width() - element.width() ) / 2+parent.scrollLeft() + 'px');
	},

	// get 'option id' from 'option value'
	_getOptionID: function(optionValue)
	{
		var optionID = this.dictionaryCache[optionValue];
		if (optionID != undefined) {
			return optionID;
		}
		return null;
	},

	// get 'option id' from 'list element'
	_getOptionIDFromListElement: function(listElement)
	{
		return this._getOptionID(listElement.attr('id').replace('option-',''));
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
	 *  Widget B
	 */

	// clear widget B
	_clearWidgetB: function()
	{
		this.showLoadingAnimation(true);
		this.options.target.multiselect('setAItem').multiselect('clearWidgetB');
		this.showLoadingAnimation(false);
	},

	// get A item (widget A)
	_getAItem: function(listElement)
	{
		var optionElement = this._getOptionFromListElement(listElement);
		var optionValues = optionElement.val().split('|');
		var aItem = {};

		aItem.name = optionElement.text();
		aItem.mark = optionValues[0];
		aItem.id = optionValues[1];
		aItem.slug = optionValues[2];

		if (aItem.name != '' && aItem.mark != '' && aItem.id != '' && aItem.slug != '') {
			return aItem;
		}
		return false;
	},

	// edit A item (widget B)
	_editAItem: function(listElement)
	{
		var that = this;
		var target = this.options.target;

		// get A item (widget A)
		var aItem = this._getAItem(listElement);

		// can't get full item > die quietly
		if (!aItem) return;

		// set A item (widget B)
		target.multiselect('setAItem', aItem.id, aItem.name, aItem.slug, aItem.mark);

		// select associated B items (widget B)
		$.ajax({
			async: true,
			url: this.options.getBItemsAction + '/' + aItem.id,
			dataType: 'json',
			//global: false,
			success: function(response) {
				if (response.bItems != false) {
					target.multiselect('selectBItems', response.bItems.reverse());
				}
			}
		});
 	},


	/**
	 *  Widget A
	 */

	// update number of options in select list
	_updateCount: function(number)
	{
		if (isNaN(number)){
			return false;
		}
		this.aggresiveSearch = ((this.count += number) <= this.options.aggresiveSearchTrigger) ? true : false;
	},

	// unselect selected A items (widget A)
	_unselectSelectedItems: function()
	{
		var selectedItems = this.availableList.children('li.ui-state-active');
		var selectedItemsCount = selectedItems.size();

		if (selectedItemsCount != 0) {
			if (selectedItemsCount <= 20) {
				// trigger click event if few elements selected
				selectedItems.map(function() {
					$(this).click();
				});
			} else {
				// remove all A items and repopulate widget A
				this._populateLists(this.element.children('option').removeAttr('selected'));
			}
		}
	},

	// set selected/unselected state to A item (widget A)
	_setSelected: function(listElement, selected)
	{
		var optionID = this._getOptionIDFromListElement(listElement);
		this._getOptionFromID(optionID).attr('selected', selected);

		if (selected) {
			this._unselectSelectedItems();
			listElement.children('span').addClass('ui-icon-folder-open').removeClass('ui-icon-folder-collapsed');
			listElement.addClass('ui-state-active ui-priority-primary');
		} else {
			listElement.children('span').addClass('ui-icon-folder-collapsed').removeClass('ui-icon-folder-open');
			listElement.removeClass('ui-state-active ui-priority-primary');
		}
		//return false;
	},

	// regenerate search cache (widget A)
	_regenerateSearchListCache: function()
	{
		this.searchListCache = this.availableList.children('li').map(function(){
			return $(this).text().toLowerCase();
		});
		this.expiredSearchListCache = false;
	},

	// regenerate dictionary for fast indexing (widget A)
	_regenerateDictionaryCache: function()
	{
		var options = this.element.children('option');
		var optionValue = null;
		var dictionary = [];

		for (var i=0; i< options.length; i++) {
			optionValue = options[i].value.split('|')[1];
			dictionary[optionValue] = i;
		}
		this.dictionaryCache = dictionary;
	},

	// register search events (widget A)
	_registerSearchEvents: function(input)
	{
		var that = this;
		this._regenerateSearchListCache();

		this._updateCount(0);

		// unbind previous binded events
		input.unbind('focus').unbind('blur').unbind('keyup.multiselect').unbind('keydown.multiselect');

		// bind new events
		input.bind('focus', function() {
//			$.log(that.count);
//			$.log(that.aggresiveSearch);
			$(this).addClass('ui-state-active');
			if (that.expiredSearchListCache) {
				that._regenerateSearchListCache();
			}
		})
		.bind('blur', function() {
			$(this).removeClass('ui-state-active');
		})
		.bind('keyup.multiselect', function(e) {
			var keyCode = $.ui.keyCode;
			switch (e.keyCode) {
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
			switch (e.keyCode) {
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

	// filter A list elements when searching (widget A)
	_filter: function(list, listCache)
	{
		var input = $(this);
		var searchTerm = $.trim(input.val().toLowerCase());
		var rows = list.children('li');
		var scores = [];

		if (this.cachedTerm == searchTerm) {
				//$.log('is cached');
				return;
		}
		this.cachedTerm = searchTerm;

		if (searchTerm.length<3) {
			//$.log('too short');
			if (rows.is(':hidden')) {
				//$.log('start repopulate');
				var start = 0;
				var end = 0;
				var offset = 100;
				var bounds = [];

				do {
					end = start + offset;
					bounds.push([start,end]);
					start += offset;
				} while(end < rows.size());
				bounds.reverse();

				var bound = null;
				for (var i=0; i<bounds.length; i++) {
					//$.log('timer '+i);
					window.setTimeout(function() {
						bound = bounds.pop();
						currentRows = rows.slice(bound[0], bound[1]);
						currentRows.css('display','block');
						//$.log(currentRows);
						//$.log(currentRows.last());
					}, i*50);
				}
			}
			return;
		}

		if(searchTerm) {
			//$.log('match!');
			rows.css('display','none');
			listCache.each(function(i) {
				if (this.indexOf(searchTerm) >= 0) {
					scores.push(i);
				}
			});
			$.each(scores, function() {
				$(rows[this]).css('display','block');
			});
		}
	},

	// populate widget A list
	_populateLists: function(options)
	{
		var that = this;
		var count = 0;
		var optionText = null;
		var optionValues = null;
		var optionMark = null;
		var optionValue = null;
		var dictionary = [];
		var availableList = '';
		//this.availableList.children('.ui-element').remove();

		for (var i=0; i< options.length; i++) {
			optionText = options[i].text;
			optionValues = options[i].value.split('|');

			optionMark = optionValues[0];
			optionValue = optionValues[1];
			dictionary[optionValue] = i;

			optionMark = (parseInt(optionMark)) ? ' ui-state-error' : '';

			if (options[i].selected) {
				availableList += '<li id="option-'+optionValue+'" class="ui-state-default ui-element ui-state-active ui-priority-primary'+optionMark+'" title="['+optionValue+'] '+optionText+'">'+
									optionText+
									'<span class="ui-corner-all ui-icon ui-icon-folder-open"/>'+
								'</li>';
			} else {
				availableList += '<li id="option-'+optionValue+'" class="ui-state-default ui-element'+optionMark+'" title="['+optionValue+'] '+optionText+'">'+
									optionText+
									'<span class="ui-corner-all ui-icon ui-icon-folder-collapsed"/>'+
								'</li>';
			}
			count += 1;
		}
		this.count = count;

		// create dictionary for fast indexing
		this.dictionaryCache = dictionary;

		// insert list items in proper container
		this.availableList.html(availableList);
	}

/*	_loadingSmall: function(status)
	{
		var loader = this.upperBar.children('.loadingSmall:first');
		if(status==true) {
			loader.css('visibility','visible');
		}else {
			loader.css('visibility','hidden');
		}
	},*/

});

})(jQuery);
