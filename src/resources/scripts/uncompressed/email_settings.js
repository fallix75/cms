(function($) {

var EmailSettingsForm = Blocks.Base.extend({

	$protocolField: null,
	$protocolSelect: null,
	$hiddenFields: null,
	$protocolSettingsPane: null,
	$protocolSettingsPaneHead: null,
	$protocolSettingsPaneBody: null,
	protocol: null,

	init: function()
	{
		this.$protocolField = $('#protocol-field');
		this.$protocolSelect = $('#protocol');
		this.$hiddenFields = $('#hidden-fields');

		this._onEmailTypeChange();
		this.addListener(this.$protocolSelect, 'change', '_onEmailTypeChange');

		// Initialize Switch and Pill fields
		this.smtpAuthSwitch = new Blocks.ui.LightSwitch('#smtpAuth', {
			onChange: $.proxy(this, '_onSmtpAuthChange')
		});
	},

	getField: function(fieldIndex)
	{
		return $('#'+EmailSettingsForm.protocolFields[this.protocol][fieldIndex]+'-field');
	},

	_onEmailTypeChange: function()
	{
		if (this.protocol && this.protocol in EmailSettingsForm.protocolFields)
		{
			// Detach the old fields
			for (var i = 0; i < EmailSettingsForm.protocolFields[this.protocol].length; i++)
			{
				this.getField(i).appendTo(this.$hiddenFields);
			}
		}

		this.protocol = this.$protocolSelect.val();

		if (this.protocol in EmailSettingsForm.protocolFields)
		{
			// Attach the new fields
			var $lastField = this.$protocolField;
			for (var j = 0; j < EmailSettingsForm.protocolFields[this.protocol].length; j++)
			{
				var $field = this.getField(j);
				$field.insertAfter($lastField);
				$lastField = $field;
			}
		}
	}

}, {
	protocolFields: {
		smtp:  ['host', 'port', 'smtpKeepAlive', 'smtpAuth', 'smtpAuthCredentials', 'smtpSecureTransportType', 'timeout'],
		pop:   ['username', 'password', 'host', 'port', 'timeout'],
		gmail: ['username', 'password']
	}
});

Blocks.emailSettingsForm = new EmailSettingsForm();

})(jQuery);
