	<div class="row footer-main">
		<ul>
			<li>Environment: <b>{{ App::environment(); }}</b></li>
			<li>setlocale(LC_ALL, 0): <b><?php echo setlocale(LC_ALL, 0); ?></b></li>
			<li>Cache admin: <b><?php echo Config::get('typicms.cacheadmin') ? 'enabled': 'disabled'; ?></b></li>
			<li>Cache public: <b><?php echo Config::get('typicms.cachepublic') ? 'enabled': 'disabled'; ?></b></li>
		</ul>
	</div>
