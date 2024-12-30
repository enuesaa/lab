import { getUnitFiles } from '$lib/prototype/server/files'
import { getProject } from '$lib/prototype/server/project'
import { error } from '@sveltejs/kit'

export const load = async () => {
	if (import.meta.env.PROD) {
		error(404, 'Page not found')
	}


	const project = await getProject('go-fx-di-httpcall-cli')
	const unitfiles = await getUnitFiles(project)

	return { project, files: unitfiles['コード全体'] }
}
