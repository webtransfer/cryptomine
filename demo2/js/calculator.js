function Calculator(container) {
	var self = this;


	this.boot = function() {
		self.select();
		self.calculation();

		$(container).find('select').change(function() {
			self.updateAmount();
			self.calculation();
		});

		$(container).find('.amount').keyup(function () {
			var str = $(this).val();
			var newStr = str.replace(/[^0-9\.]+/, '');

			if ( str != newStr ) {
				$(this).val(newStr);
			}

			self.calculation();
		});
	};
	
	this.updateAmount = function() {
		$(container).find('.amount').val((200 / self.getCurrentPrice()).toFixed(2));
	};

	this.select = function(id) {
		var id = id || $(container).find('select option:first').data('id');
		$(container).find('select option:selected').removeAttr('selected');
		$(container).find('select option:visible[data-id="' + id + '"]').attr('selected', true);
		self.updateAmount();
		//$(container).find('select').trigger("change");
	};

	this.calculation = function() {
		$(container).find('.cName').text(self.getCurrentShortName());
		$(container).find('tr').removeClass('profit100');

		$(container).find('.calculation').each(function() {
			var days = $(this).data('days');
			var amount = self.getAmount();
			var price = self.getCurrentPrice();
			var speed = self.getCurrentSpeed();
			var cld = amount * price / self.getPrice();

			var profit = cld * speed * 1440 * days;

			$(this).find('.profit').text(profit.toFixed(8));
			$(this).find('.profitInUsd').text((profit * price).toFixed(8));
			$(this).find('.profitInPercent').text((profit / amount * 100).toFixed(2));
			
			if ( profit >= amount ) {
				$(this).addClass('profit100');
			}
		});
	};

	this.getPrice = function() {
		return $('meta[name="price"]').attr('content');
	};

	this.getAmount = function() {
		return $(container).find('.amount').val();
	};

	this.getCurrent = function() {
		return $(container).find('select option:selected');
	};

	this.getCurrentID = function() {
		return self.getCurrent().data('id');
	};
	
	this.getCurrentMin = function() {
		return self.getCurrent().data('min');
	};

	this.getCurrentPrice = function() {
		return self.getCurrent().data('price');
	};

	this.getCurrentSpeed = function() {
		return self.getCurrent().data('speed');
	};

	this.getCurrentShortName = function() {
		return self.getCurrent().data('short_name');
	};
}