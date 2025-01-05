import { extractInlineFile } from '$lib/prototype/server/files'
import { extractCodeFiles } from '$lib/prototype/server/files'
import { copyUnitImage } from '$lib/prototype/server/image'
import { getProjectV2, listProjectsV2 } from '$lib/prototype/server/project'

export const load = async ({ params: { name } }) => {
	let project = await getProjectV2(name)
	project = await extractCodeFiles(project)
	project = await extractInlineFile(project)
	await copyUnitImage(project)

	return { project }
}

type Entry = {
	name: string
}
export async function entries(): Promise<Entry[]> {
	const projects = await listProjectsV2()
	const list = projects.map((p) => ({ name: p.name }))
	return list
}
