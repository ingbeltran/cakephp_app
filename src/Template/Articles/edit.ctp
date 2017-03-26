<!-- File: src/Template/Articles/edit.ctp -->

<h1>Editar Artículo</h1>
<?php
	echo $this->Form->create($article);
	echo $this->Form->input('title');
	echo $this->Form->input('body', ['rows' => '3']);
	echo $this->Form->button(__('Guardar articulo'));
	echo $this->Form->end();
?>