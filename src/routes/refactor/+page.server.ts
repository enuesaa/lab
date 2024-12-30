import { error } from '@sveltejs/kit'

export const load = () => {
	if (import.meta.env.PROD) {
		error(404, 'Page not found')
	}

	return {}
}
