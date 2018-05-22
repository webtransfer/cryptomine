$(document).ready(function () {
	// template fix
	if ( window.pageYOffset > 0 ) {
		//console.log(window.pageYOffset);
		$('#headerNav').addClass('minimized').addClass('dark');
	}
	
	// Check tickets
	if ( isAuthenticated() && window.location.href.indexOf('/tickets') <= 0 ) {
		var lastTickets = [];
		var getNewReplies = function () {
			clearInterval(getNewRepliesInterval);
			getNewRepliesInterval = setInterval(getNewReplies, 60000);

			$.ajax({
				type: 'POST',
				url: "/account/tickets/getNewReplies.json",
				dataType: 'json',
				success: function(data) {
					if ( data.status && data.amount > 0 ) {
						var show = [];
						var showI = 0;
						for ( var tID in data.tickets ) {
							var ticket = data.tickets[tID];
							if ( typeof lastTickets[tID] === 'undefined' || lastTickets[tID] > ticket.updated ) {
								show[showI++] = '<a href="' + ticket.link + '" target="blank">' + ticket.title + '</a>';
							}

							lastTickets[tID] = ticket.updated;
						}

						if ( show.length > 0 ) {
							noty({
								text: appLang.newReplies + show.join(', '),
								layout: 'bottomRight',
								theme: 'relax',
								type: 'warning',
								timeout: false,
								closeWith: ['click', 'button']
							});
						}
					}
				}
			});
		};
		var getNewRepliesInterval = setInterval(getNewReplies, 3000);
	}
	
	// Captha
	$('#captcha').click(function() {
		reloadCaptcha();
	});
	
	// Balance
	if ( $('#checkPayments').length > 0 ) {
		$('#checkPayments').removeAttr('disabled'); // fix
	}
	$('#checkPayments').click(function () {
		var self = this;
		var btnOldName = $(this).text();
		var maxAttemps = 6 * 10;
		//var maxAttemps = 1;
		var seconds = maxAttemps * 10;
		var attemps = 0;
		$(this).attr('disabled', 'disabled');
		$(this).text(appLang.updating);
		
		$('#checkPaymentsTimer').show();
		var countDownInterval = setInterval(function() {
			$('#second').text(--seconds);
		}, 1000);
		
		var intervalID = setInterval(function() {
			updateBalance(function(data) {
				$(self).removeAttr('disabled');
				$(self).text(btnOldName);
				clearInterval(intervalID);
				clearInterval(countDownInterval);
				$('#checkPaymentsTimer').hide();

				var show = [];
				var showI = 0;
				for ( var cID in data.newPayments ) {
					show[showI++] = data.newPayments[cID] + ' ' + appLang.currencies[cID].short_name;
				}

				noty({
					text: appLang.newPayments1 + show.join(', ') + appLang.newPayments2,
					layout: 'bottomRight',
					theme: 'relax',
					type: 'success',
					timeout: false,
					closeWith: ['click', 'button']
				});
			});
			
			if ( ++attemps >= maxAttemps ) {
				noty({
					text: appLang.paymentsNotFound,
					layout: 'bottomRight',
					theme: 'relax',
					type: 'warning',
					timeout: false,
					closeWith: ['click', 'button']
				});
				
				$(self).removeAttr('disabled');
				$(self).text(btnOldName);
				clearInterval(intervalID);
				clearInterval(countDownInterval);
				$('#checkPaymentsTimer').hide();
			}
		}, 10000);
		
		return false;
	});
	
	
	if ( $('#btnUpdateBalance').length > 0 ) {
		$('#btnUpdateBalance').removeAttr('disabled'); // fix
	}
	$('#btnUpdateBalance').click(function () {
		alert(appLang.checkPaymentsInform);
		window.location.href = "/finances/deposit";
		
		return false;
	});
	
	// Ajax forms
	$('.ajaxForm').find('*[disabled="disabled"]').removeAttr('disabled');
	$('.ajaxForm').find('*[disabled=""]').removeAttr('disabled');
	$('.ajaxForm').submit(function() {
		var self = this;
		$('*[type="submit"]', this).attr("disabled", "disabled");
		
		$.ajax({
			type: $(this).data('method'),
			url: $(this).data('action'),
			dataType: 'json',
			data: $(this).serialize(),
			success: function(data) {
				var callback = $(self).data('callback') ? $(self).data('callback') : false;
				
				if ( callback && typeof window[callback] == 'function' ) {
					window[callback](data);
				}
				
				$('*[type="submit"]', self).removeAttr("disabled");
			}, error: function() {
				noty({
					text: appLang.serverError,
					layout: 'bottomRight',
					theme: 'relax',
					type: 'error',
					timeout: false,
					closeWith: ['click', 'button']
				});
				
				$('*[type="submit"]', self).removeAttr("disabled");
			}
		});
		
		return false;
	});
	
	
	// Exchange
	$('#exchangeForm').submit(function() {
		//$(this).attr("disabled", "disabled");

		$.ajax({
			type: 'POST',
			url: "/finances/exchange/processing.json",
			dataType: 'json',
			data: $(this).serialize(),
			success: function(data) {
				if ( data.status ) {
					noty({
						text: appLang.successExchange,
						layout: 'center',
						theme: 'relax',
						type: 'success',
						timeout: 3000,
						closeWith: ['click', 'button'],
						callback: {
							onClose: function() {
								location.reload();
							}
						}
					});
				} else {
					noty({
						text: data.error.message,
						layout: 'center',
						theme: 'relax',
						type: 'warning',
						timeout: false,
						closeWith: ['click', 'button']
					});
				}
			}, error: function() {
				noty({
					text: appLang.serverError,
					layout: 'bottomRight',
					theme: 'relax',
					type: 'error',
					timeout: false,
					closeWith: ['click', 'button']
				});
			}
		});
		
		return false;
	});
	
	$('#exchangeForm #currencyID').change(function () {
		$('#amount').val(parseFloat($('option:selected', this).data("amount")).toFixed(8));
		$("#exchangeResult").text(
			(parseFloat($('option:selected', this).data("amount")) * parseFloat($('option:selected', this).data("price")) / getPrice()).toFixed(8)
		);
		var name = $('option:selected', this).text();
		$("#img").attr('src' ,"/ing/" + name + ".png");
	});
	
	/*$('#exchangeForm #amount').change(function () {
		var selected = $('#currencyID option:selected');
		//console.log(selected);
		
		$("#exchangeResult").text(
			parseFloat($(this).val() * selected.data("price") / getPrice()).toFixed(8)
		);
	});*/
	$('#exchangeForm #amount').keyup(function () {
		var str = $(this).val();
		var newStr = str.replace(/[^0-9\.]+/, '');
		
		if ( str != newStr ) {
			$(this).val(newStr);
		}
		
		var selected = $('#currencyID option:selected');
		//console.log(selected);
		
		$("#exchangeResult").text(
			parseFloat(newStr * selected.data("price") / getPrice()).toFixed(8)
		);
	});
	
	
	// Profile
	$('#profileForm').submit(function() {
		$.ajax({
			type: 'POST',
			url: "/account/profile/processing.json",
			dataType: 'json',
			data: $(this).serialize(),
			success: function(data) {
				if ( data.status ) {
					noty({
						text: appLang.dataSaved,
						layout: 'bottomRight',
						theme: 'relax',
						type: 'success',
						timeout: false,
						closeWith: ['click', 'button']
					});
				} else {
					noty({
						text: data.error.message,
						layout: 'bottomRight',
						theme: 'relax',
						type: 'warning',
						timeout: false,
						closeWith: ['click', 'button']
					});
				}
			}, error: function() {
				noty({
					text: appLang.serverError,
					layout: 'bottomRight',
					theme: 'relax',
					type: 'error',
					timeout: false,
					closeWith: ['click', 'button']
				});
			}
		});
		return false;
	});
	
	// Withdraw
	$('#withdrawForm').submit(function() {
		$.ajax({
			type: 'POST',
			url: "/finances/withdraw/processing.json",
			dataType: 'json',
			data: $(this).serialize(),
			success: function(data) {
				if ( data.status ) {
					noty({
						text: appLang.withdrawSuccess,
						layout: 'center',
						theme: 'relax',
						type: 'success',
						timeout: 3000,
						closeWith: ['click', 'button'],
						callback: {
							onClose: function() {
								location.reload();
							}
						}
					});
				} else {
					noty({
						text: data.error.message,
						layout: 'center',
						theme: 'relax',
						type: 'warning',
						timeout: false,
						closeWith: ['click', 'button']
					});
				}
			}, error: function() {
				noty({
					text: appLang.serverError,
					layout: 'bottomRight',
					theme: 'relax',
					type: 'error',
					timeout: false,
					closeWith: ['click', 'button']
				});
			}
		});
		return false;
	});
	
	$('#withdrawForm #currencyID').change(function () {
		$('#amount').val(parseFloat($('option:selected', this).data("amount-with-take")));
		var takeAmount = parseFloat($('option:selected', this).data("take-amount"));
		var name = $('option:selected', this).text();
		var shortName = $('option:selected', this).data("short-name");
		$("#img").attr('src' ,"/ing/" + name + ".png");
		
		if ( takeAmount > 0 ) {
			$('#takeAmount').show();
			$('#takeAmount .amount').text(takeAmount);
			$('#takeAmount .currency').text(shortName);
		} else {
			$('#takeAmount').hide();
		}
	});
	
	
	// Deposit
	$('.createWallet').click(function() {
		var self = this;
		$(this).attr('disabled', 'disabled');
		var cID = $(this).data('currency_id');
		
		$.ajax({
			type: 'POST',
			url: "/finances/createWallet.json",
			dataType: 'json',
			data: {
				cID: cID
			},
			success: function(data) {
				if ( data.status ) {
					noty({
						text: appLang.walletCreated,
						layout: 'bottomRight',
						theme: 'relax',
						type: 'success',
						timeout: false,
						closeWith: ['click', 'button']
					});
					
					$('input[data-currency_id="' + cID + '"]').val(data.wallet);
					$('div[data-currency_id="' + cID + '"]').show();
					$('.createWallet_' + cID).hide();
					$(self).removeAttr('disabled');
				} else {
					noty({
						text: data.error.message,
						layout: 'bottomRight',
						theme: 'relax',
						type: 'warning',
						timeout: false,
						closeWith: ['click', 'button']
					});
				}
				$(self).removeAttr('disabled');
			}, error: function() {
				noty({
					text: appLang.serverError,
					layout: 'bottomRight',
					theme: 'relax',
					type: 'error',
					timeout: false,
					closeWith: ['click', 'button']
				});
				$(self).removeAttr('disabled');
			}
		});
		
		return false;
	});
	
	
	// Mining
    var select = $('#value-select').val();
    var renderPrice, renderCount, RenderSum, renderSpeed, cloudCount;
    renderPrice = $("#" + select + "").find('.renderPrice');
    renderSpeed = $("#" + select + "").find('.renderSpeed').val();
    renderCount = $("#" + select + "").find('.renderCount');
    RenderSum = $("#" + select + "").find('.renderSum');
    var test = $("#" + select + "").find('#tsar');
    cloudCount = $('.cloud').val();
    var c = $("#cloudvalue");
    var sum = parseFloat(parseFloat(renderCount.text()) * parseFloat(renderPrice.text())).toFixed(8);
    if (select) {
    	$('#' + select).addClass('activet');
    	//$('#'+select).find('.btn').addClass('activet');
    	setInterval(function() {
    		if (select == 'cloud') {
    			var cl = parseFloat(renderCount.text()) + parseFloat(cloudCount) * parseFloat(0.0000047839506173 / 600);
    			c.val(parseFloat(renderCount.text()).toFixed(8))
    			renderCount.text(parseFloat(cl).toFixed(10));
    		} else {
    			test.val(parseFloat(renderSpeed / 600) * parseFloat(cloudCount) + parseFloat(test.val()));
    			renderCount.text(parseFloat(test.val()).toFixed(8));
    			RenderSum.text(parseFloat(parseFloat(test.val()) * parseFloat(renderPrice.text())).toFixed(8));
    		}
    	}, 100);
    }
});


function updateBalance(onSuccess, onError) {
	$.ajax({
		type:"POST",
		url: "/finances/update.json",
		dataType: 'json',
		success: function (data) {
			if ( data.status && data.newPayments !== false && typeof onSuccess === 'function' ) {
				onSuccess(data);
			}
		},
		error: function() {
			if ( typeof onSuccess === 'function' ) {
				onError();
			}
		}
	});
}


function reloadCaptcha() {
	$('#captcha').attr('src', '/captcha?' + Math.random());
}

// Retrieve
function retrieve(data) {
	if ( data.status ) {
		noty({
			text: appLang.retrieveSuccess,
			layout: 'center',
			theme: 'relax',
			type: 'success',
			timeout: 5000,
			closeWith: ['click', 'button'],
			callback: {
				onClose: function() {
					window.location.href = "/";
				}
			}
		});
	} else {
		noty({
			text: data.error.message,
			layout: 'center',
			theme: 'relax',
			type: 'warning',
			timeout: false,
			closeWith: ['click', 'button']
		});
		reloadCaptcha();
	}
}

// Create ticket
function createTicket(data) {
	if ( data.status ) {
		noty({
			text: appLang.createTicketSuccess,
			layout: 'center',
			theme: 'relax',
			type: 'success',
			timeout: 3000,
			closeWith: ['click', 'button'],
			callback: {
				onClose: function() {
					window.location.href = data.URL;
				}
			}
		});
	} else {
		noty({
			text: data.error.message,
			layout: 'center',
			theme: 'relax',
			type: 'warning',
			timeout: false,
			closeWith: ['click', 'button']
		});
		//reloadCaptcha();
	}
}

// Reply ticket
function replyTicket(data) {
	if ( data.status ) {
		$('textarea[name="message"]').text('');
		noty({
			text: appLang.replyTicketSuccess,
			layout: 'center',
			theme: 'relax',
			type: 'success',
			timeout: 3000,
			closeWith: ['click', 'button'],
			callback: {
				onClose: function() {
					location.reload();
				}
			}
		});
	} else {
		noty({
			text: data.error.message,
			layout: 'center',
			theme: 'relax',
			type: 'warning',
			timeout: false,
			closeWith: ['click', 'button']
		});
		//reloadCaptcha();
	}
}

function closeTicket(data) {
	if ( data.status ) {
		noty({
			text: appLang.closeTicketSuccess,
			layout: 'center',
			theme: 'relax',
			type: 'success',
			timeout: 3000,
			closeWith: ['click', 'button']
		});
	} else {
		noty({
			text: data.error.message,
			layout: 'center',
			theme: 'relax',
			type: 'warning',
			timeout: false,
			closeWith: ['click', 'button']
		});
	}
}

function deleteTicket(data) {
	if ( data.status ) {
		noty({
			text: appLang.deleteTicketSuccess,
			layout: 'center',
			theme: 'relax',
			type: 'success',
			timeout: 3000,
			closeWith: ['click', 'button']
		});
	} else {
		noty({
			text: data.error.message,
			layout: 'center',
			theme: 'relax',
			type: 'warning',
			timeout: false,
			closeWith: ['click', 'button']
		});
	}
}



// Registration
function registration(data) {
	if ( data.status ) {
		if ( typeof data.redirect !== 'undefined' ) {
			window.location.href = data.redirect;
		} else {
			noty({
				text: appLang.registrationSuccess + data.login,
				layout: 'center',
				theme: 'relax',
				type: 'success',
				timeout: false,
				closeWith: ['click', 'button'],
				callback: {
					onClose: function() {
						window.location.href = "/account/login";
					}
				}
			});
		}
	} else {
		noty({
			text: data.error.message,
			layout: 'center',
			theme: 'relax',
			type: 'warning',
			timeout: false,
			closeWith: ['click', 'button']
		});
		reloadCaptcha();
	}
}

function login(data) {
	if ( data.status || data.error.code == 108 ) {
		window.location.href = "/mining";
	} else {
		noty({
			text: data.error.message,
			layout: 'center',
			theme: 'relax',
			type: 'warning',
			timeout: false,
			closeWith: ['click', 'button']
		});
	}
}

function refbackPercent(data) {
	if ( data.status ) {
		noty({
			text: appLang.RefbackSaved,
			layout: 'bottomRight',
			theme: 'relax',
			type: 'success',
			timeout: false,
			closeWith: ['click', 'button']
		});
	} else {
		noty({
			text: data.error.message,
			layout: 'bottomRight',
			theme: 'relax',
			type: 'warning',
			timeout: false,
			closeWith: ['click', 'button']
		});
	}
}

function reinvestPercent(data) {
	if ( data.status ) {
		noty({
			text: appLang.ReinvestSaved,
			layout: 'bottomRight',
			theme: 'relax',
			type: 'success',
			timeout: false,
			closeWith: ['click', 'button']
		});
	} else {
		noty({
			text: data.error.message,
			layout: 'bottomRight',
			theme: 'relax',
			type: 'warning',
			timeout: false,
			closeWith: ['click', 'button']
		});
	}
}

function promo(data) {
	if ( data.status ) {
		noty({
			text: appLang.successPromo,
			layout: 'bottomRight',
			theme: 'relax',
			type: 'success',
			timeout: 3000,
			closeWith: ['click', 'button'],
			callback: {
				onClose: function() {
					location.reload();
				}
			}
		});
	} else {
		noty({
			text: data.error.message,
			layout: 'bottomRight',
			theme: 'relax',
			type: 'warning',
			timeout: false,
			closeWith: ['click', 'button']
		});
	}
}

function gotos(name){
    $.ajax({
        type: 'POST',
        url: "/lc/"+name,
        success: function (html) {
            $('.template').html(html)
        }
    })

}

function mining(id){
    $.ajax({
        type:"POST",
        data: "id="+id,
        url:"/lc/setfarm",
        success: function () {
			location.reload();
        }
    });
}

function getUnixTime() {
	return Math.floor(Date.now() / 1000);
}

function getPrice() {
	return $('meta[name="price"]').attr('content');
}

function isAuthenticated() {
	return $('meta[name="authenticated"]').attr('content') ? true : false;
}