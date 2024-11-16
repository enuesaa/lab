import type { UnitWithTreeData } from '$lib/types/tree'
import type { PageServerLoad } from './$types'
import { readConfig } from '$lib/server/trailer/config'
import { extractVariantFiles } from '$lib/server/trailer/variant'
import { listTrailers } from '$lib/server/trailer/list'

type Data = {
	name: string
	title: string
	description: string
	published: string
	units: UnitWithTreeData[]
}
export const load: PageServerLoad<Data> = async ({ params: { name } }) => {
	const config = await readConfig(name)
	const data: Data = {
		name,
		title: config.title,
		description: config.description,
		published: config.published,
		units: [],
	}
	for (const unit of config.units) {
		data.units.push({
			...unit,
			files: await extractVariantFiles(name, unit.name),
		})
	}
	return data
}

type Entry = {
	name: string
}
export async function entries(): Promise<Entry[]> {
	const list = await listTrailers()
	return list.map((v) => ({ name: v }))
}
