import { readConfig } from './config'
import fs from 'node:fs/promises'
import type { Project, ProjectV2 } from '$lib/prototype/types'
import YAML from 'yaml'

const listNames = async (): Promise<string[]> => {
	const files = await fs.readdir('./data', { withFileTypes: true })
	return files.map((f) => f.name)
}

export const listProjects = async (): Promise<Project[]> => {
	let list = []

	for (const name of await listNames()) {
		try {
			const project = await getProject(name)
			list.push(project)
		} catch (e) {}
	}

	// sort by published desc
	list.sort((a, b) => (a.published > b.published ? -1 : 1))

	return list
}

/**
 * @deprecated
 * @throws if project is in private.
 */
export const getProject = async (name: string): Promise<Project> => {
	const config = await readConfig(name)
	const project = {
		name,
		title: config.title,
		description: config.description,
		published: config.published,
		units: config.units,
	}

	// ignore if published is null
	if (project.published === undefined || project.published === null) {
		throw new Error('Not Found')
	}

	return project
}

/**
 * @throws if project is in private.
 */
export const getProjectV2 = async (name: string): Promise<ProjectV2> => {
	const path = `./data/${name}/.prototype.yml`
	const text = await fs.readFile(path, 'utf8')

	const dotprototype = YAML.parse(text)
	const project = { name, ...dotprototype } as ProjectV2

	// ignore if published is null
	if (project.published === undefined || project.published === null) {
		throw new Error('Not Found')
	}

	return project
}
