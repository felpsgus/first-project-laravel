import { ref } from 'vue'
import axios from 'axios'
import { useRouter } from 'vue-router'

axios.defaults.baseURL = 'http://localhost:8000/api/v1'

export default function useEnderecos() {
	const enderecos = ref([])
	const endereco = ref({
		id: '',
		cep: '',
		logradouro: '',
		bairro: '',
		cidade: '',
		uf: ''
	})
	const errors = ref([])
	const message = ref('')
	const router = useRouter()
	const carregarModal = ref(false)
	const carregarDash = ref(false)

	const getEnderecos = async () => {
		carregarDash.value = true
		await axios.get('').then((response) => {
			carregarDash.value = false
			enderecos.value = response.data.data
		})
	}

	const getEndereco = async id => {
		const response = await axios.get('/' + id)
		endereco.value = response.data.data[0]
	}

	const searchEndereco = async data => {
		carregarDash.value = true
		await axios
			.get('/' + data, {
				headers: {
					'Content-Type': 'application/json',
					Accept: 'application/json'
				}
			})
			.then(response => {
				carregarDash.value = false
				enderecos.value = response.data.data
			})
			.catch(error => {
				carregarDash.value = false
				message.value = {
					msg:
						error.response.data.message ||
						'Erro ao buscar endereço!',
					type: 'danger'
				}
			})
	}

	const saveEndereco = async data => {
		carregarModal.value = true
		await axios
			.post('', data, {
				headers: {
					'Content-Type': 'application/json',
					Accept: 'application/json'
				}
			})
			.then(() => {
				carregarModal.value = false
				message.value = {
					msg: 'Endereço cadastrado com sucesso!',
					type: 'success'
				}
				document.getElementById('modalClose').click()
			})
			.catch(error => {
				carregarModal.value = false
				message.value = {
					msg:
						error.response.data.message ||
						'Erro ao cadastrar endereço!',
					type: 'danger'
				}
				if (
					error.response.status === 422 &&
					error.response.data.errors
				)
				{
					errors.value = error.response.data.errors
				}
			})
	}

	const updateEndereco = async (id, data) => {
		carregarModal.value = true
		await axios
			.patch('/' + id, data, {
				headers: {
					'Content-Type': 'application/json',
					Accept: 'application/json'
				}
			})
			.then(response => {
				carregarModal.value = false
				message.value = {
					msg: 'Endereço atualizado com sucesso!',
					type: 'success'
				}
				document.getElementById('modalClose').click()
			})
			.catch(error => {
				carregarModal.value = false
				message.value = {
					msg:
						error.response.data.message ||
						'Erro ao atualizar endereço!',
					type: 'danger'
				}
				if (
					error.response.status === 422 &&
					error.response.data.errors
				)
				{
					errors.value = error.response.data.errors
				}
			})
	}

	const deleteEndereco = async id => {
		if (!confirm('Deseja realmente excluir este endereço?'))
		{
			return
		}
		carregarModal.value = true
		await axios.delete(`/${id}`).then(() => {
			carregarModal.value = false
			message.value = {
				msg: 'Endereço excluído com sucesso!',
				type: 'success'
			}
		})

		await getEnderecos()
	}

	return {
		enderecos,
		endereco,
		errors,
		getEnderecos,
		getEndereco,
		saveEndereco,
		updateEndereco,
		deleteEndereco,
		searchEndereco,
		carregarModal,
		carregarDash,
		message
	}
}
