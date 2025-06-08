import fs from 'node:fs/promises'
import path from 'node:path'
import type { ProjectV2 } from '$lib/prototype/types'
import { parseAttrs } from '../attrs'

export const copyUnitImage = async (project: ProjectV2) => {
	const publishdir = path.join('./static/prototype', project.name)

	try {
		// remove old assets
		await fs.rm(publishdir, { recursive: true })
	} catch (e) {}

	for (const unit of project.units) {
		if (unit.image === undefined) {
			continue
		}
		const parsed = parseAttrs(unit.image)
		const filename = parsed.content

		const src = path.join('./data', project.name, filename)
		const dest = path.join(publishdir, filename)

		try {
			await fs.mkdir(publishdir, { recursive: true })
			await fs.copyFile(src, dest)
		} catch (e) {
			console.error(e)
		}
	}
}
