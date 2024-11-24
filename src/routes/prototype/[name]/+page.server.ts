import type { PageServerLoad } from './$types'
import { copyUnitImage, getProject, getUnitFiles, listProjects } from '$lib/prototype/server/export'
import type { Project, UnitFiles } from '$lib/prototype/types'

type Data = {
	project: Project
	unitfiles: UnitFiles
}
export const load: PageServerLoad<Data> = async ({ params: { name } }) => {
	const project = await getProject(name)
	const unitfiles = await getUnitFiles(project)
	await copyUnitImage(project)

	return { project, unitfiles }
}

type Entry = {
	name: string
}
export async function entries(): Promise<Entry[]> {
	const projects = await listProjects()
	const list = projects.map((p) => ({ name: p.name }))
	return list
}
