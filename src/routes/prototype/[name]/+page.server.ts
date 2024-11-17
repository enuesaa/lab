import type { PageServerLoad } from './$types'
import { getProject, getUnitFiles } from '$lib/prototype/server/export'
import { listNames } from '$lib/prototype/server/list'
import type { Project, UnitFiles } from '$lib/prototype/types'

type Data = {
	project: Project
	unitfiles: UnitFiles
}
export const load: PageServerLoad<Data> = async ({ params: { name } }) => {
	const project = await getProject(name)
	const unitfiles = await getUnitFiles(project)

	return {project, unitfiles}
}

type Entry = {
	name: string
}
export async function entries(): Promise<Entry[]> {
	const names = await listNames()
	const list = names.map((name) => ({ name }))
	return list
}
