<h2>
  <?php echo $this->translate("SEO Plugin") ?>
</h2>

<?php if( count($this->navigation) ): ?>
  <div class='tabs'>
    <?php
      // Render the menu
      //->setUlClass()
      echo $this->navigation()->menu()->setContainer($this->navigation)->render()
    ?>
  </div>
<?php endif; ?>

<p>
  Manage SEO settings here.
</p>

<script type="text/javascript">
  var currentOrder = '<?php echo $this->order ?>';
  var currentOrderDirection = '<?php echo $this->order_direction ?>';
  var changeOrder = function(order, default_direction){
    // Just change direction
    if( order == currentOrder ) {
      $('order_direction').value = ( currentOrderDirection == 'ASC' ? 'DESC' : 'ASC' );
    } else {
      $('order').value = order;
      $('order_direction').value = default_direction;
    }
    $('filter_form').submit();
  }


function selectAll()
{
  var i;
  var multimodify_form = $('multimodify_form');
  var inputs = multimodify_form.elements;
  for (i = 1; i < inputs.length - 1; i++) {
    if (!inputs[i].disabled) {
      inputs[i].checked = inputs[0].checked;
    }
  }
}
</script>

<br />
<div class='admin_search'>
  <?php echo $this->formFilter->render($this) ?>
</div>

<br />

<div class='admin_results'>
  <div>
    <?php $count = $this->paginator->getTotalItemCount() ?>
    <?php echo $this->translate(array("%s object found", "%s objects found", $count),
        $this->locale()->toNumber($count)) ?>
  </div>
  <div>
    <?php echo $this->paginationControl($this->paginator, null, null, array(
      'pageAsQuery' => true,
      'query' => $this->formValues,
      //'params' => $this->formValues,
    )); ?>
  </div>
</div>
<br />
<div class="admin_table_form">
<form id='multimodify_form' method="post" action="<?php echo $this->url(array('action'=>'multi-modify'));?>" onSubmit="multiModify()">
  <table class='admin_table'>
    <thead>
      <tr>
        <th style='width: 1%;'><input onclick="selectAll()" type='checkbox' class='checkbox'></th>
        <th style='width: 1%;'><a href="javascript:void(0);" onclick="javascript:changeOrder('id', 'DESC');"><?php echo $this->translate("ID") ?></a></th>
        <th style='width: 1%;'><?php echo $this->translate("Type") ?></th>
        <th><a href="javascript:void(0);" onclick="javascript:changeOrder('title', 'ASC');"><?php echo $this->translate("Title") ?></a></th>
        <th><?php echo $this->translate("URL") ?></th>
        <th style='width: 1%;'><a href="javascript:void(0);" onclick="javascript:changeOrder('creation_date', 'DESC');"><?php echo $this->translate("Created") ?></a></th>
        <th style='width: 1%;' class='admin_table_options'><?php echo $this->translate("Options") ?></th>
      </tr>
    </thead>
    <tbody>
      <?php if( count($this->paginator) ): ?>
        <?php foreach( $this->paginator as $item ): ?>
          <tr>
            <td><input name='modify_<?php echo $item->getIdentity();?>' value=<?php echo $item->getIdentity();?> type='checkbox' class='checkbox'></td>
            <td><?php echo $item->getIdentity() ?></td>
            <td><?php echo $item->getType() ?></td>
            <td class='admin_table_bold'> <?php echo $item->getTitle() ?></td>
            <td class='admin_table_href'>
              <?php if ($this->altUrl($item)): ?>
              <?php echo $this->htmlLink($this->altUrl($item), '/' . $this->altUrl($item), array('target' => '_blank')); ?>
              <?php else: ?>
              <?php echo $this->htmlLink($item, $item->getHref(), array('target' => '_blank')) ?>
              <?php endif ?>
            </td>
            <td class="nowrap">
              <?php
                try {
                  echo $this->locale()->toDateTime($item->creation_date);
                } catch (Exception $e) {
                  echo '&nbsp;';
                }
              ?>
            </td>
            <td class='admin_table_options'>
              <a class='smoothbox' href='<?php echo $this->url(array('action' => 'edit', 'id' => $item->getGuid()));?>'>
                <?php echo $this->translate("edit") ?>
              </a>
              &nbsp;|&nbsp;
              <a class='smoothbox' href='<?php echo $this->url(array('action' => 'reset', 'id' => $item->getGuid()));?>'>
                <?php echo $this->translate("reset") ?>
              </a>
            </td>
          </tr>
        <?php endforeach; ?>
      <?php endif; ?>
    </tbody>
  </table>
  <br />
</form>
</div>
