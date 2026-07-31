import axios from 'axios'

const API_BASE_URL = import.meta.env.VITE_API_BASE_URL || 'http://localhost:8000/api/v1'

export function useApi() {
  const get = async (endpoint, params = {}) => {
    try {
      const response = await axios.get(`${API_BASE_URL}${endpoint}`, { params })
      return { data: response.data, error: null }
    } catch (error) {
      console.error(`API GET error for ${endpoint}:`, error)
      return { data: null, error: error.message }
    }
  }

  const post = async (endpoint, data = {}) => {
    try {
      const response = await axios.post(`${API_BASE_URL}${endpoint}`, data)
      return { data: response.data, error: null }
    } catch (error) {
      console.error(`API POST error for ${endpoint}:`, error)
      return { data: null, error: error.message }
    }
  }

  const put = async (endpoint, data = {}) => {
    try {
      const response = await axios.put(`${API_BASE_URL}${endpoint}`, data)
      return { data: response.data, error: null }
    } catch (error) {
      console.error(`API PUT error for ${endpoint}:`, error)
      return { data: null, error: error.message }
    }
  }

  const del = async (endpoint) => {
    try {
      const response = await axios.delete(`${API_BASE_URL}${endpoint}`)
      return { data: response.data, error: null }
    } catch (error) {
      console.error(`API DELETE error for ${endpoint}:`, error)
      return { data: null, error: error.message }
    }
  }

  return { get, post, put, del }
}
