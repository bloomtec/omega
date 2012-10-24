				<?php if($this -> Session -> read('Auth.User') && $this -> Session -> read('Auth.User.rol_id') != 3) { ?>
				<div class="sf-menu-container">
					<ul class="sf-menu">
						<li>
							<a href="/admin/empresas">
								Empresas
							</a>
							<ul>
								<li>
									<a href="/admin/empresas/add">
										Crear Empresa
									</a>
								</li>
							</ul>
						</li>
						<li>
							<a href="/admin/usuarios">
								Usuarios
							</a>
							<ul>
								<li>
									<a href="/admin/usuarios/add">
										Crear Admin.
									</a>
								</li>
							</ul>
						</li>
						<li>
							<a href="#">
								Parametros
							</a>
							<ul>
								<li>
									<a href="/admin/categorias_archivos">
									Cat. De Archivos
									</a>
									<ul>
										<li>
											<a href="/admin/categorias_archivos/add">Crear Categoría</a>
										</li>
									</ul>
								</li>
							</ul>
						</li>
						<li>
							<?php echo $this -> Html -> link('Salir', array('controller' => 'usuarios', 'action' => 'logout')); ?>
						</li>
					</ul>
				</div>
				<?php } elseif($this -> Session -> read('Auth.User')) { ?>
				<div class="sf-menu-container">
					<ul class="sf-menu">
						<li>
							<a href="/admin/empresas">
								Inicio
							</a>
						</li>
						<li>
							<?php echo $this -> Html -> link('Salir', array('controller' => 'usuarios', 'action' => 'logout')); ?>
						</li>
					</ul>
				</div>
				<?php } ?>