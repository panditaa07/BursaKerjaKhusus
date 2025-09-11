<td class="text-center">
                                @if($p->status == 'accepted')
                                    <span class="badge bg-success">Diterima</span>
                                @elseif($p->status == 'rejected')
                                    <span class="badge bg-danger">Ditolak</span>
                                @elseif($p->status == 'interview')
                                    <span class="badge bg-warning text-dark">Wawancara</span>
                                @elseif($p->status == 'test1')
                                    <span class="badge bg-info">Test 1</span>
                                @elseif($p->status == 'test2')
                                    <span class="badge bg-primary">Test 2</span>
                                @elseif($p->status == 'submitted')
                                    <span class="badge bg-secondary">Menunggu</span>
                                @else
                                    <span class="badge bg-light text-dark">{{ $p->status }}</span>
                                @endif
                            </td>
