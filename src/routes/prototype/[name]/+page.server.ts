import { extractInlineFile } from '$lib/prototype/server/files'
import { extractCodeFiles } from '$lib/prototype/server/files'
import { getProjectV2, listProjects } from '$lib/prototype/server/project'
import { error } from '@sveltejs/kit'

export const load = async ({ params: { name } }) => {
	if (import.meta.env.PROD) {
		error(404, 'Page not found')
	}

	let project = await getProjectV2(name)
	project = await extractCodeFiles(project)
	project = await extractInlineFile(project)

	return { project }
}

type Entry = {
	name: string
}
export async function entries(): Promise<Entry[]> {
	const projects = await listProjects()
	const list = projects.map((p) => ({ name: p.name }))
	return list
}
