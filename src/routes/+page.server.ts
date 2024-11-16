import type { PageServerLoad } from './$types'
import { listPrototypeProjects } from '$lib/server/prototype/list'
import type { PrototypeProject } from '$lib/server/prototype/types'

type Data = {
	projects: PrototypeProject[]
}
export const load: PageServerLoad<Data> = async () => {
	const projects = await listPrototypeProjects()

	return { projects }
}
