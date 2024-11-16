import type { PageServerLoad } from './$types'
import { getProject } from '$lib/prototype/server/project'
import { extractFiles } from '$lib/prototype/server/files'
import { listPrototypeNames } from '$lib/prototype/server/list'
import type { Project, UnitWithTreeData } from '$lib/prototype/types'

type Data = Project & {
	units: UnitWithTreeData[]
}
export const load: PageServerLoad<Data> = async ({ params: { name } }) => {
	const project = await getProject(name)
	const data: Data = {
		...project,
		units: [],
	}
	for (const unit of project.units) {
		data.units.push({
			...unit,
			files: await extractFiles(name),
		})
	}
	return data
}

type Entry = {
	name: string
}
export async function entries(): Promise<Entry[]> {
	const names = await listPrototypeNames()
	const list = names.map((name) => ({ name }))

	return list
}
