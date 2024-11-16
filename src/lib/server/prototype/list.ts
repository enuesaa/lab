import fs from 'node:fs/promises'
import { readConfig } from './config'
import type { PrototypeProject } from './types'

export const listPrototypeNames = async (): Promise<string[]> => {
	const files = await fs.readdir('./data', { withFileTypes: true })
	return files.map((f) => f.name)
}

export const listPrototypeProjects = async (): Promise<PrototypeProject[]> => {
	const list = []

	for (const name of await listPrototypeNames()) {
		const config = await readConfig(name)
		const project = {
			name,
			title: config.title,
			description: config.description,
			published: config.published,
		}
		list.push(project)
	}

	// sort by published desc
	list.sort((a, b) => a.published > b.published ? 1 : -1)

	return list
}
