<script setup>
import useEnderecos from '../composables/enderecos'
import { onMounted } from 'vue'

const {
	enderecos,
	endereco,
	message,
	carregarModal,
	carregarDash,
	errors,
	getEndereco,
	getEnderecos,
	searchEndereco,
	deleteEndereco,
	saveEndereco,
	updateEndereco
} = useEnderecos()

onMounted(() => {
	getEnderecos()
})

let search = ''
let routeModal = 'cadastrar'

function editarEndereco(id, route) {
	routeModal = route
	getEndereco(id)
}

function closeModal() {
	getEnderecos()
}
</script>

<template>
	<br />
	<div class="container-fluid">
		<div class="row d-flex justify-content-between">
			<form class="col-md-4 mb-3" @submit.prevent="searchEndereco(search)">
				<div class="input-group mb-3">
					<label for="cep" class="input-group-text">Cep</label>
					<input type="text" class="form-control" placeholder="Pesquise por cep e rua"
						aria-describedby="button-addon" v-model="search" />
					<button class="btn btn-outline-secondary" type="submit" id="button-addon" style="
							border-top-right-radius: 0.375rem;
							border-bottom-right-radius: 0.375rem;
						">
						<i class="bi bi-search"></i>
					</button>
				</div>
			</form>
			<div class="col-md-2 mb-3">
				<button type="button" class="btn btn-primary float-end" data-bs-toggle="modal" data-bs-target="#modal"
					@click="routeModal = 'cadastrar'">
					<i class="bi bi-plus-lg"></i> Cadastrar
				</button>
			</div>
		</div>
		<div class="row">
			<div class="loadingParent" v-if="carregarDash">
				<div class="loading"></div>
				<p>Carregando...</p>
			</div>
		</div>
		<div class="alert alert-dismissible fade show" role="alert" :class="{
			'alert-success': message.type == 'success',
			'alert-danger': !message.type == 'success'
		}" v-if="message">
			{{ message.msg }}
			<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
		</div>
		<div class="shadow-lg p-4 rounded mb-5">
			<table class="table table-light">
				<thead class="position-sticky">
					<tr>
						<th scope="col">Cep</th>
						<th scope="col">Logradouro</th>
						<th scope="col">Bairro</th>
						<th scope="col">Cidade</th>
						<th scope="col">Uf</th>
						<th></th>
						<th></th>
					</tr>
				</thead>
				<tbody>
					<tr v-for="endereco in enderecos">
						<td>{{ endereco.cep }}</td>
						<td>{{ endereco.logradouro }}</td>
						<td>{{ endereco.bairro }}</td>
						<td>{{ endereco.cidade }}</td>
						<td>{{ endereco.uf }}</td>
						<td>
							<button @click="deleteEndereco(endereco.id)" class="btn btn-warning text-white">
								<i class="bi bi-trash"></i>
							</button>
						</td>
						<td>
							<button type="button" class="btn btn-primary float-end" data-bs-toggle="modal"
								data-bs-target="#modal" @click="editarEndereco(endereco.id, 'editar')">
								<i class="bi bi-pencil-square"></i>
							</button>
						</td>
					</tr>
				</tbody>
			</table>
		</div>
		<div class="modal" tabindex="-1" id="modal">
			<div class="modal-dialog modal-xl">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title">Cadastro de Endereço</h5>
						<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
					</div>
					<div class="modal-body">
						<div class="container-fluid">
							<div class="row">
								<div class="loadingParent" v-if="carregarModal">
									<div class="loading"></div>
									<p>Carregando...</p>
								</div>
							</div>
							<div class="alert alert-danger alert-dismissible fade show" role="alert"
								v-for="error in errors">
								{{ error[0] }}
								<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
							</div>
							<div class="alert alert-dismissible fade show" role="alert" :class="{
								'alert-success': message.type == 'success',
								'alert-danger': message.type == 'danger'
							}" v-if="message">
								{{ message.msg }}
								<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
							</div>

							<div class="">
								<form @submit.prevent="
									routeModal == 'cadastrar'
										? saveEndereco(endereco)
										: updateEndereco(
											endereco.id,
											endereco
										)
									">
									<div class="row">
										<input type="hidden" id="id" name="id" v-model="endereco.id" />
										<div class="col-md-2 mb-3">
											<label for="cep" class="form-label">Cep</label>
											<input type="text" class="form-control" id="cep" name="cep"
												v-model="endereco.cep" :class="{
													'is-invalid': errors.cep
												}" />
										</div>
										<div class="col-md-10 mb-3">
											<label for="rua" class="form-label">Logradouro</label>
											<input type="text" class="form-control" id="rua" name="rua"
												v-model="endereco.logradouro" :class="{
													'is-invalid':
														errors.logradouro
												}" />
										</div>
									</div>
									<div class="row">
										<div class="col-md-6 mb-3">
											<label for="bairro" class="form-label">Bairro</label>
											<input type="text" class="form-control" id="bairro" name="bairro"
												v-model="endereco.bairro" :class="{
													'is-invalid': errors.bairro
												}" />
										</div>
										<div class="col-md-5 mb-3">
											<label for="cidade" class="form-label">Cidade</label>
											<input type="text" class="form-control" id="cidade" name="cidade"
												v-model="endereco.cidade" :class="{
													'is-invalid': errors.cidade
												}" />
										</div>
										<div class="col-md-1 mb-3">
											<label for="estado" class="form-label">Uf</label>
											<input type="text" class="form-control" id="estado" name="estado" maxlength="2"
												v-model="endereco.uf" :class="{
													'is-invalid': errors.uf
												}" />
										</div>
									</div>
									<br />
									<div class="row">
										<div class="col-2 ms-auto d-flex justify-content-end">
											<button type="button" class="btn btn-secondary me-4" data-bs-dismiss="modal"
												id="modalClose" @click="closeModal()">
												Close
											</button>
											<button type="submit" class="btn btn-primary">
												Salvar
											</button>
										</div>
									</div>
								</form>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</template>

<style>
.loadingParent {
	font-size: 20px;
	width: min-content;
	margin-left: auto;
	margin-right: auto;
	align-content: center;
}

.loading {
	animation: rodar 2s linear infinite;
	margin-left: auto;
	margin-right: auto;
	border-top: 4px solid #000;
	border-right: 4px solid rgba(255, 255, 255, 0);
	border-bottom: 4px solid #000;
	border-left: 4px solid rgba(255, 255, 255, 0);
	border-radius: 100%;
	width: 50px;
	height: 50px;
}

@keyframes rodar {
	from {
		transform: rota;
	}

	to {
		transform: rotate(360deg);
	}
}
</style>
