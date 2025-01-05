import type { PageServerLoad } from './$types'
import { listProjectsV2 } from '$lib/prototype/server/project'
import type { ProjectV2 } from '$lib/prototype/types'

type Data = {
	projects: ProjectV2[]
}
export const load: PageServerLoad<Data> = async () => {
	const projects = await listProjectsV2()

	return { projects }
}
