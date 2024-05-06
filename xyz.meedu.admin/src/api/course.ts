import client from "./internal/httpClient";

// 线上课详情

export function list(params: any) {
  return client.get(`/backend/api/v1/course`, params);
}

export function create() {
  return client.get(`/backend/api/v1/course/create`, {});
}

export function store(params: any) {
  return client.post("/backend/api/v1/course", params);
}

export function detail(id: number) {
  return client.get(`/backend/api/v1/course/${id}`, {});
}

export function destroy(id: number) {
  return client.destroy(`/backend/api/v1/course/${id}`);
}

export function update(id: number, params: any) {
  return client.put(`/backend/api/v1/course/${id}`, params);
}

// 获取播放地址
export function playUrl(courseId: number, hourId: number) {
  return client.get(`/api/v1/course/${courseId}/hour/${hourId}`, {});
}

// 记录学员观看时长
export function record(courseId: number, hourId: number, duration: number) {
  return client.get(`/api/v1/course/${courseId}/hour/${hourId}/record`, {
    duration,
  });
}

export function userImport(id: number, params: any) {
  return client.post(`/backend/api/v1/course/${id}/subscribe/import`, params);
}

export function categoryList(params: any) {
  return client.get(`/backend/api/v1/courseCategory`, params);
}

export function categoryDestroy(id: number) {
  return client.destroy(`/backend/api/v1/courseCategory/${id}`);
}

export function categoryCreate() {
  return client.get(`/backend/api/v1/courseCategory/create`, {});
}

export function categoryStore(params: any) {
  return client.post("/backend/api/v1/courseCategory", params);
}

export function categoryDetail(id: number) {
  return client.get(`/backend/api/v1/courseCategory/${id}`, {});
}

export function categoryUpdate(id: number, params: any) {
  return client.put(`/backend/api/v1/courseCategory/${id}`, params);
}

export function commentList(params: any) {
  return client.get(`/backend/api/v1/course_comment`, params);
}

export function commentDestroy(params: any) {
  return client.post(`/backend/api/v1/course_comment/delete`, params);
}

export function videoList(params: any) {
  return client.get(`/backend/api/v1/video`, params);
}

export function videoDestoryMulti(params: any) {
  return client.post(`/backend/api/v1/video/delete/multi`, params);
}

export function videoCreate(id: number) {
  return client.get(`/backend/api/v1/course_chapter/${id}`, {});
}

export function videoStore(params: any) {
  return client.post("/backend/api/v1/video", params);
}

export function videoDetail(id: number) {
  return client.get(`/backend/api/v1/video/${id}`, {});
}

export function videoUpdate(id: number, params: any) {
  return client.put(`/backend/api/v1/video/${id}`, params);
}

export function videoSubscribe(id: number, params: any) {
  return client.get(`/backend/api/v1/video/${id}/subscribes`, params);
}

export function videoSubscribeDestory(id: number, params: any) {
  return client.get(`/backend/api/v1/video/${id}/subscribe/delete`, params);
}

export function videoWatchRecords(id: number, params: any) {
  return client.get(`/backend/api/v1/video/${id}/watch/records`, params);
}

export function videoImportAct(params: any) {
  return client.post("/backend/api/v1/video/import", params);
}

export function videoCommentList(params: any) {
  return client.get(`/backend/api/v1/video_comment`, params);
}

export function videoCommentDestroy(params: any) {
  return client.post(`/backend/api/v1/video_comment/delete`, params);
}

export function recordsList(id: number, params: any) {
  return client.get(`/backend/api/v1/course/${id}/watch/records`, params);
}

export function recordsDestroy(id: number, params: any) {
  return client.post(
    `/backend/api/v1/course/${id}/watch/records/delete`,
    params
  );
}

export function recordsDetail(id: number, userId: number, params: any) {
  return client.get(
    `/backend/api/v1/course/${id}/user/${userId}/watch/records`,
    params
  );
}

export function subUsers(id: number, params: any) {
  return client.get(`/backend/api/v1/course/${id}/subscribes`, params);
}

export function subUsersAdd(id: number, params: any) {
  return client.post(`/backend/api/v1/course/${id}/subscribe/create`, params);
}

export function subUsersDel(id: number, params: any) {
  return client.get(`/backend/api/v1/course/${id}/subscribe/delete`, params);
}

export function attachList(params: any) {
  return client.get(`/backend/api/v1/course_attach`, params);
}

export function attachStore(params: any) {
  return client.post(`/backend/api/v1/course_attach`, params);
}

export function attachDestory(id: number) {
  return client.destroy(`/backend/api/v1/course_attach/${id}`);
}

export function chaptersList(id: number, params: any) {
  return client.get(`/backend/api/v1/course_chapter/${id}`, params);
}

export function chaptersDestroy(id: number, ids: any) {
  return client.destroy(`/backend/api/v1/course_chapter/${id}/${ids}`);
}

export function chaptersStore(id: number, params: any) {
  return client.post(`/backend/api/v1/course_chapter/${id}`, params);
}

export function chaptersDetail(id: number, ids: any) {
  return client.get(`/backend/api/v1/course_chapter/${id}/${ids}`, {});
}

export function chaptersUpdate(id: number, ids: any, params: any) {
  return client.put(`/backend/api/v1/course_chapter/${id}/${ids}`, params);
}
