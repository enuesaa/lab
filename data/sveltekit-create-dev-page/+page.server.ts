import { error } from '@sveltejs/kit'

export const load = async () => {
	// 本番環境なら (≒ vite build なら)
	if (import.meta.env.PROD) {
		error(404, 'Page not found')
	}

	return {}
}
