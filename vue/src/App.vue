<script setup>
import { RouterView } from 'vue-router'

</script>

<template>
	<header class="position-sticky">
		<div class="container">
			<nav class="navbar">
				<div class="container-fluid border-bottom">
					<h1>Dashboard</h1>
				</div>
			</nav>
		</div>
	</header>

	<main>
		<div class="container">
			<RouterView />
		</div>
	</main>
</template>

