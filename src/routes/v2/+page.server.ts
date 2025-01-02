import { getCodeFiles } from '$lib/prototype/server/files'
import { getProjectV2 } from '$lib/prototype/server/project'
import { error } from '@sveltejs/kit'

export const load = async () => {
	if (import.meta.env.PROD) {
		error(404, 'Page not found')
	}

	const project = await getProjectV2('go-fx-di-httpcall-cli-v2')
	const codeFiles = await getCodeFiles(project)

	return { project, codeFiles }
}
