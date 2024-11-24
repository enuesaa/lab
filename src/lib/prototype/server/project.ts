import type { Project } from '../types'
import { readConfig } from './config'
import fs from 'node:fs/promises'

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
