var mag_ajax_js = Object.create( null );

;( function( $, window, document, undefined ) {

	'use strict';

	mag_ajax_js.init_ajax = function( ) {
		$('.cmb-post-search-ajax').each(
			function () {
				var fid 		= $(this).attr('name');
				var name        = $(this).attr('id');
				var query_args 	= $(this).attr('data-queryargs');
				var object		= $(this).attr('data-object');
	
				name = name.replace( "][", "_" );
				name = name.replace( "]", "" );
				name = name.replace( "[", "_" );

				// We need to replace the _store with the new ID,
				fid = fid.replace( "][", "_" );
				fid = fid.replace( "]", "" );
				fid = fid.replace( "[", "_" );

				var storeReplace = $(this).closest('.cmb-row.cmb-type-post-search-ajax');
				console.log('====== CMBROW =======');
				console.log(storeReplace);
				console.log(name);
				console.log(fid);
				if ( storeReplace.hasClass( 'cmb-repeat-group-field' ) ) {
					console.log('====== hasClass =======');
					console.log(storeReplace);
					var fieldReplace     = undefined;
					var searchReplace    = undefined;
					var emptyResultsList = false;
					var searchID         = false;

					// Replace the ajax search input ID.
					searchReplace = storeReplace.find( '.cmb-td' ).find('input.cmb-post-search-ajax');
					if ( 0 < searchReplace.length ) {
						searchID = searchReplace.attr('name');
						searchReplace.attr('ID', searchID );
					}

					// Run through the store fields and replace the results list.
					fieldReplace = storeReplace.find( '.cmb-td' ).find('input.cmb-post-search-ajax-store');
					console.log(fieldReplace);
					if ( 0 < fieldReplace.length ) {
						fieldReplace.attr('name',fid + '_store');
						console.log('store replaced');

						if ( false !== searchID ) {
							fieldReplace.attr('id',searchID + '_store');
						}
					}

					if ( '' === fieldReplace.val() ) {
						storeReplace.find( '.cmb-post-search-ajax-results' ).empty();
					}
				}
	
				$(this).devbridgeAutocomplete({
					serviceUrl: psa.ajaxurl,
					type: 'POST',
					triggerSelectOnValidInput: false,
					showNoSuggestionNotice: true,
					transformResult: function(r) {
						var suggestions = $.parseJSON(r);
						if($('input#'+name+' li').length){
							var selected_vals 	= Array();
							var d 				= 0;
							$('input#'+name+' input').each(function(index, element) {
								selected_vals.push( $(this).val() );
							});
							$(suggestions).each(function(ri, re){
								if($.inArray((re.data).toString(), selected_vals) > -1){
									suggestions.splice(ri-d, 1);
									d++;
								}
							});
						}
						$(suggestions).each(function(ri, re){
							re.value = $('<textarea />').html(re.value).text();
						});
						return {suggestions: suggestions};
					},
					params:{
						action  	: 'cmb_post_search_ajax_get_results',
						psacheck	: psa.nonce,
						object		: object,
						query_args	: query_args,
					},
					onSearchStart: function(){
						$(this).next('img.cmb-post-search-ajax-spinner').css('display', 'inline-block');
					},
					onSearchComplete: function(){
						$(this).next('img.cmb-post-search-ajax-spinner').hide();
					},
					onSelect: function (suggestion) {
						$(this).devbridgeAutocomplete('clearCache');
						var lid 	 = $(this).attr('id') + '_results';
						var name     = $(this).attr('id');
						var original = $(this).attr('id');
						var groupName = $(this).attr('name');
						name = name.replace( "][", "_" );
						name = name.replace( "]", "" );
						name = name.replace( "[", "_" );

						console.log('====== LID =======');
						console.log(lid);
						console.log('====== name =======');
						console.log(name);
						console.log('====== suggestion =======');
						console.log(suggestion);

						console.log($(this).closest('.cmb-row').hasClass('cmb-repeat-group-field'));
						console.log($(this).closest('.cmb-row').hasClass('lsx-field-connect-field'));
						if ( $(this).closest('.cmb-row').hasClass('cmb-repeat-group-field') && $(this).closest('.cmb-row').hasClass('lsx-field-connect-field') ) {
							name = original;
						}
						console.log('====== Original =======');
						console.log(original);
						console.log('====== new name =======');
						console.log(name);
	
						var limit 	 = $(this).attr('data-limit');
						var sortable = $(this).attr('data-sortable');
						if ( limit > 1 ) {
							var handle = (sortable == 1) ? '<span class="hndl"></span>' : '';
							$(this).closest('.cmb-row').find( '.cmb-post-search-ajax-results' ).append('<li>'+handle+'<input type="hidden" name="'+lid+'[]" value="'+suggestion.data+'"><a href="'+suggestion.guid+'" target="_blank" class="edit-link">'+suggestion.value+'</a><a class="remover"><span class="dashicons dashicons-no"></span><span class="dashicons dashicons-dismiss"></span></a></li>');

							$(this).val('');
							if ( limit === $('input#'+name + '_results li').length ){
								$(this).prop( 'disabled', 'disabled' );
							} else {
								$(this).focus();
							}

							mag_ajax_js.populateStoreField( $(this), name );

						} else {
							$( 'input#'+name ).val( suggestion.data );
							$( 'input[name="'+name + '_store"]' ).val( suggestion.data );
							console.log('limit store' + limit);
							console.log($( 'input#'+name + '_store' ));
						}

						if ( $(this).closest('.cmb-row').hasClass('cmb-repeat-group-field') && limit > 1 ) {
							console.log('cmb-group');
							console.log( groupName );
							groupName = groupName.replace( "][", "_" );
							groupName = groupName.replace( "]", "" );
							groupName = groupName.replace( "[", "_" );
							
							mag_ajax_js.populateStoreField( $(this), groupName );
						}
					}
				});			
			
				if($(this).attr('data-sortable') == 1){
					$('input#'+name).sortable({ 
						handle				 : '.hndl', 
						placeholder			 : 'ui-state-highlight', 
						forcePlaceholderSize : true 
					});	
				}
				
				if($(this).attr('data-limit') == 1){
					$(this).on('blur', function(){
						if($(this).val() === ''){
							var name     = $(this).attr('id');
							name = name.replace( "][", "_" );
							name = name.replace( "]", "" );
							name = name.replace( "[", "_" );
							$('input#'+name).val('');
						}
					});
				}
			
			}
		);
	};

	mag_ajax_js.populateStoreField = function( ele, name ) {
		console.log(name);

		if ( 0 < ele.closest('.cmb-row').find( '.cmb-post-search-ajax-results').length ) {
			var resultValues = ele.closest('.cmb-row').find( '.cmb-post-search-ajax-results li input' ).map( function(){return $(this).val();} ).get();
		} else if ( 0 < ele.closest('.cmb-row').find( '.cmb-post-search-ajax-store').length ) {
			var resultValues = ele.closest('.cmb-row').find( 'input#'+name + '_store' ).map( function(){return $(this).val();} ).get();
		}
		console.log(resultValues);
		console.log(name);
		if ( 0 === resultValues.length ) {
			$( 'input[name='+name+'_store]' ).val( '' );
		} else {
			$( 'input[name='+name+'_store]' ).val( resultValues.join(',') );
		}
	};

	mag_ajax_js.watch_remove_click = function() {
		$('.cmb-post-search-ajax-results').on( 'click', 'a.remover', function(){
			$(this).parent('li').fadeOut( 0, function(){ 
				var iid     = $(this).parent('ul').attr('id').replace('_results', '');
				var cmb_row = $(this).closest('.cmb-row');

				console.log( iid );
				$(this).remove(); 
				$('#' + iid).removeProp( 'disabled' );
				$('#' + iid).devbridgeAutocomplete('clearCache');

				if ( cmb_row.hasClass('cmb-repeat-group-field') ) {				
					var groupName = $(this).find('input').attr('name').replace('_results[]', '');
					groupName = groupName.replace( "][", "_" );
					groupName = groupName.replace( "]", "" );
					groupName = groupName.replace( "[", "_" );
					console.log( groupName );
					console.log( cmb_row );
					mag_ajax_js.populateStoreField( cmb_row, groupName );
				} else {
					mag_ajax_js.populateStoreField( cmb_row, iid );
				}
			});
		});
	};

	mag_ajax_js.event_init = function( evt, $row ) {
		mag_ajax_js.init_ajax();
	};

	$(document).ready(function() {
		mag_ajax_js.init_ajax();
		mag_ajax_js.watch_remove_click();
		$( document ).on( 'cmb2_add_row', mag_ajax_js.event_init )
	});


} )( jQuery, window, document );
