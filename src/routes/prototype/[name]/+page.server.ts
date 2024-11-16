import type { PageServerLoad } from './$types'
import { getProjectWithFiles } from '$lib/prototype/server/export'
import { listNames } from '$lib/prototype/server/list'
import type { Project, UnitWithTreeData } from '$lib/prototype/types'

type Data = Project & {
	units: UnitWithTreeData[]
}
export const load: PageServerLoad<Data> = async ({ params: { name } }) => {
	return await getProjectWithFiles(name)
}

type Entry = {
	name: string
}
export async function entries(): Promise<Entry[]> {
	const names = await listNames()
	const list = names.map((name) => ({ name }))
	return list
}
