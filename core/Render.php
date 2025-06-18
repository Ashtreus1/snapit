<?php

class Render {
	private $layout = 'layouts/default';
	private $data = [];

	public function setLayout($layout){
		$this->layout = $layout;
	}

	public function view($viewPath, $data = []){
		$this->data = $data;

		ob_start();
		$this->includeView($viewPath, $data);
		$content = ob_get_clean();

		$this->data['content'] = $content;

		$this->renderLayout();
	}

	private function includeView($path, $data){
		$path = str_replace('.', '/', $path);
		extract($data); 
		require BASE_PATH . '/views/' . $path . '.php';
	}

	private function renderLayout(){
		ob_start();
		extract($this->data); 
		require BASE_PATH . '/views/' . $this->layout . '.php';
		$output = ob_get_clean();
		echo $this->callback($output);
	}

	protected function callback($buffer){
		return $buffer;
	}
}
