<?php
/**
 * @package     Joomla.Administrator
 * @subpackage  com_newsfeeds
 *
 * @copyright   Copyright (C) 2005 - 2012 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

// Include the HTML helpers.
JHtml::addIncludePath(JPATH_COMPONENT.'/helpers/html');
JHtml::_('behavior.tooltip');
JHtml::_('behavior.formvalidation');
JHtml::_('behavior.keepalive');
JHtml::_('formbehavior.chosen', 'select');

$app = JFactory::getApplication();
$input = $app->input;

$assoc = isset($app->item_associations) ? $app->item_associations : 0;
?>
<script type="text/javascript">
	Joomla.submitbutton = function(task)
	{
		if (task == 'newsfeed.cancel' || document.formvalidator.isValid(document.id('newsfeed-form'))) {
			Joomla.submitform(task, document.getElementById('newsfeed-form'));
		}
	}
</script>

<form action="<?php echo JRoute::_('index.php?option=com_newsfeeds&id='.(int) $this->item->id); ?>" method="post" name="adminForm" id="newsfeed-form" class="form-validate form-horizontal">
	<div class="row-fluid">
		<!-- Begin Newsfeed -->
		<div class="span10 form-horizontal">

	<fieldset>
	<ul class="nav nav-tabs">
		<li class="active"><a href="#details" data-toggle="tab"><?php echo empty($this->item->id) ? JText::_('COM_NEWSFEEDS_NEW_NEWSFEED') : JText::sprintf('COM_NEWSFEEDS_EDIT_NEWSFEED', $this->item->id); ?></a></li>
		<li><a href="#publishing" data-toggle="tab"><?php echo JText::_('JGLOBAL_FIELDSET_PUBLISHING');?></a></li>
		<?php
		$fieldSets = $this->form->getFieldsets('params');
		foreach ($fieldSets as $name => $fieldSet) :
		?>
		<li><a href="#params-<?php echo $name;?>" data-toggle="tab"><?php echo JText::_($fieldSet->label);?></a></li>
		<?php endforeach; ?>
		<?php
		$fieldSets = $this->form->getFieldsets('metadata');
		foreach ($fieldSets as $name => $fieldSet) :
		?>
		<li><a href="#metadata-<?php echo $name;?>" data-toggle="tab"><?php echo JText::_($fieldSet->label);?></a></li>
		<?php endforeach; ?>
		<?php if ($assoc): ?>
			<li><a href="#associations" data-toggle="tab"><?php echo JText::_('JGLOBAL_FIELDSET_ASSOCIATIONS');?></a></li>
		<?php endif; ?>
	</ul>

	<div class="tab-content">
		<div class="tab-pane active" id="details">
			<div class="control-group">
				<div class="control-label"><?php echo $this->form->getLabel('name'); ?></div>
				<div class="controls"><?php echo $this->form->getInput('name'); ?></div>
			</div>
			<div class="control-group">
				<div class="control-label"><?php echo $this->form->getLabel('link'); ?></div>
				<div class="controls"><?php echo $this->form->getInput('link'); ?></div>
			</div>
			<div class="control-group">
				<div class="control-label"><?php echo $this->form->getLabel('catid'); ?></div>
				<div class="controls"><?php echo $this->form->getInput('catid'); ?></div>
			</div>
			<div class="control-group">
				<div class="control-label"><?php echo $this->form->getLabel('description'); ?></div>
				<div class="controls"><?php echo $this->form->getInput('description'); ?></div>
			</div>
							<div class="span6">
								<h4><?php echo JText::_('COM_NEWSFEEDS_FIELDSET_IMAGES');?></h4>
								<div class="control-group">
									<div class="control-label">
										<?php echo $this->form->getLabel('images'); ?>
									</div>
									<div class="controls">
										<?php echo $this->form->getInput('images'); ?>
									</div>
								</div>
								<?php foreach($this->form->getGroup('images') as $field): ?>
									<div class="control-group">
										<?php if (!$field->hidden): ?>
											<div class="control-label">
												<?php echo $field->label; ?>
											</div>
										<?php endif; ?>
										<div class="controls">
											<?php echo $field->input; ?>
										</div>
									</div>
								<?php endforeach; ?>
							</div>

		</div>
		<div class="tab-pane" id="publishing">
			<div class="control-group">
				<div class="control-label"><?php echo $this->form->getLabel('alias'); ?></div>
				<div class="controls"><?php echo $this->form->getInput('alias'); ?></div>
			</div>
			<div class="control-group">
				<div class="control-label"><?php echo $this->form->getLabel('id'); ?></div>
				<div class="controls"><?php echo $this->form->getInput('id'); ?></div>
			</div>
			<div class="control-group">
				<div class="control-label"><?php echo $this->form->getLabel('created_by'); ?></div>
				<div class="controls"><?php echo $this->form->getInput('created_by'); ?></div>
			</div>
			<div class="control-group">
				<div class="control-label"><?php echo $this->form->getLabel('created_by_alias'); ?></div>
				<div class="controls"><?php echo $this->form->getInput('created_by_alias'); ?></div>
			</div>
			<div class="control-group">
				<div class="control-label"><?php echo $this->form->getLabel('created'); ?></div>
				<div class="controls"><?php echo $this->form->getInput('created'); ?></div>
			</div>
			<div class="control-group">
				<div class="control-label"><?php echo $this->form->getLabel('publish_up'); ?></div>
				<div class="controls"><?php echo $this->form->getInput('publish_up'); ?></div>
			</div>
			<div class="control-group">
				<div class="control-label"><?php echo $this->form->getLabel('publish_down'); ?></div>
				<div class="controls"><?php echo $this->form->getInput('publish_down'); ?></div>
			</div>
			<?php if ($this->item->modified_by) : ?>
				<div class="control-group">
					<div class="control-label"><?php echo $this->form->getLabel('modified_by'); ?></div>
					<div class="controls"><?php echo $this->form->getInput('modified_by'); ?></div>
				</div>
				<div class="control-group">
					<div class="control-label"><?php echo $this->form->getLabel('modified'); ?></div>
					<div class="controls"><?php echo $this->form->getInput('modified'); ?></div>
				</div>
			<?php endif; ?>
			<?php if ($this->item->version) : ?>
				<div class="control-group">
					<div class="control-label">
						<?php echo $this->form->getLabel('version'); ?>
					</div>
					<div class="controls">
						<?php echo $this->form->getInput('version'); ?>
					</div>
				</div>
			<?php endif; ?>

			<?php if ($this->item->hits) : ?>
				<div class="control-group">
					<div class="control-label">
						<?php echo $this->form->getLabel('hits'); ?>
					</div>
					<div class="controls">
						<?php echo $this->form->getInput('hits'); ?>
					</div>
				</div>
			<?php endif; ?>
			<div class="control-group">
				<div class="control-label"><?php echo $this->form->getLabel('ordering'); ?></div>
				<div class="controls"><?php echo $this->form->getInput('ordering'); ?></div>
			</div>

			<div class="control-group">
				<div class="control-label"><?php echo $this->form->getLabel('numarticles'); ?></div>
				<div class="controls"><?php echo $this->form->getInput('numarticles'); ?></div>
			</div>
			<div class="control-group">
				<div class="control-label"><?php echo $this->form->getLabel('cache_time'); ?></div>
				<div class="controls"><?php echo $this->form->getInput('cache_time'); ?></div>
			</div>
			<div class="control-group">
				<div class="control-label"><?php echo $this->form->getLabel('rtl'); ?></div>
				<div class="controls"><?php echo $this->form->getInput('rtl'); ?></div>
			</div>
			<div class="control-group">
				<div class="control-label"><?php echo $this->form->getLabel('xreference'); ?></div>
				<div class="controls"><?php echo $this->form->getInput('xreference'); ?></div>
			</div>

		</div>
		<?php echo $this->loadTemplate('params'); ?>

		<?php echo $this->loadTemplate('metadata'); ?>

		<?php if ($assoc) : ?>
			<?php echo $this->loadTemplate('associations'); ?>
		<?php endif; ?>

		</div>
		</fieldset>

		<input type="hidden" name="task" value="" />
		<?php echo JHtml::_('form.token'); ?>
		</div>
		<!-- End Newsfeed -->
		<!-- Begin Sidebar -->
		<div class="span2">
			<h4><?php echo JText::_('JDETAILS');?></h4>
			<hr />
			<fieldset class="form-vertical">
				<div class="control-group">
					<div class="controls">
						<?php echo $this->form->getValue('name'); ?>
					</div>
				</div>
				<div class="control-group">
					<div class="control-label">
						<?php echo $this->form->getLabel('published'); ?>
					</div>
					<div class="controls">
						<?php echo $this->form->getInput('published'); ?>
					</div>
				</div>

				<div class="control-group">
					<div class="control-label">
						<?php echo $this->form->getLabel('access'); ?>
					</div>
					<div class="controls">
						<?php echo $this->form->getInput('access'); ?>
					</div>
				</div>
				<div class="control-group">
					<div class="control-label">
						<?php echo $this->form->getLabel('featured'); ?>
					</div>
					<div class="controls">
						<?php echo $this->form->getInput('featured'); ?>
					</div>
				</div>
				<div class="control-group">
					<div class="control-label">
						<?php echo $this->form->getLabel('language'); ?>
					</div>
					<div class="controls">
						<?php echo $this->form->getInput('language'); ?>
					</div>
				</div>
			</fieldset>
		</div>
		<!-- End Sidebar -->
	</div>
</form>
