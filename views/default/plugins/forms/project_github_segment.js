define(function (require) {

	var elgg = require('elgg');
	var $ = require('jquery');
	var Ajax = require('elgg/Ajax');
	var ajax = new Ajax();

	$(document).on('keyup keydown change', '[name="github_owner"],[name="github_repo"]', function (e) {
		var $form = $(this).closest('form');
		var owner = $('[name="github_owner"]', $form).val();
		var repo = $('[name="github_repo"]', $form).val();
		var disabled = true;
		if (owner && repo) {
			disabled = false;
		}
		$form.find('.plugins-github-releases-button').prop('disabled', disabled);
	});

	$(document).on('click', '.plugins-github-releases-button', function (e) {
		e.preventDefault();
		if ($(this).prop('disabled')) {
			return;
		}

		var $elem = $(this);
		var $form = $(this).closest('form');

		ajax.action('plugins/fetch_github_releases', {
			data: {
				github_owner: $('[name="github_owner"]', $form).val(),
				github_repo: $('[name="github_repo"]', $form).val()
			}
		}).then(function (data) {
			$elem.remove();
			$form.find('.plugins-github-releases-input-container').html(data);
		});
	});

	$(document).on('change', '.plugins-github-releases-input [type="checkbox"]', function () {
		var $wrapper = $(this).closest('.plugins-github-releases-input');
		var $form = $(this).closest('form');
		if ($wrapper.find('[type="checkbox"]:checked').length) {
			$('.plugins-project-create-release-details', $form).hide().find('[required]').each(function () {
				$(this).attr({
					'data-required': true,
					'required': false,
				});
			});
			$('.plugins-github-releases-meta', $form).show();
		} else {
			$('.plugins-project-create-release-details', $form).show().find('[data-required]').each(function () {
				$(this).attr({
					'required': true,
					'data-required': false,
				});
			});
			$('.plugins-github-releases-meta', $form).hide();
		}
	});
});


