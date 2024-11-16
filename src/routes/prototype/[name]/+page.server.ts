import type { PageServerLoad } from './$types'
import { getProject } from '$lib/server/prototype/config'
import { extractFiles } from '$lib/server/prototype/files'
import { listPrototypeNames } from '$lib/server/prototype/list'
import type { PrototypeProject } from '$lib/server/prototype/types'
import type { UnitWithTreeData } from '$lib/tree'

type Data = PrototypeProject & {
	units: UnitWithTreeData[]
}
export const load: PageServerLoad<Data> = async ({ params: { name } }) => {
	const project = await getProject(name)
	const data: Data = {
		...project,
		units: [],
	}
	for (const unit of data.units) {
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
	const list = names.map(name => ({ name }))

	return list
}
